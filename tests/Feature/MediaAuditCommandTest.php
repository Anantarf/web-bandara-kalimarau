<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MediaAuditCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_reports_missing_and_unreferenced_managed_media_without_deleting_files(): void
    {
        config()->set('media.disk', 'public');
        Storage::fake('public');
        Storage::disk('public')->put('featured-images/used.jpg', 'used');
        Storage::disk('public')->put('featured-images/orphan.jpg', 'orphan');

        Post::create([
            'title' => 'Berita Uji',
            'slug' => 'berita-uji',
            'content' => 'Konten.',
            'status' => 'draft',
            'featured_image' => 'featured-images/used.jpg',
        ]);
        Post::create([
            'title' => 'Berita Tanpa File',
            'slug' => 'berita-tanpa-file',
            'content' => 'Konten.',
            'status' => 'draft',
            'featured_image' => 'featured-images/missing.jpg',
        ]);

        $this->artisan('media:audit')
            ->expectsOutputToContain('Missing referenced files')
            ->expectsOutputToContain('featured-images/missing.jpg')
            ->expectsOutputToContain('Unreferenced files')
            ->expectsOutputToContain('featured-images/orphan.jpg')
            ->assertSuccessful();

        Storage::disk('public')->assertExists('featured-images/orphan.jpg');
    }

    public function test_it_requires_force_before_deleting_orphaned_media(): void
    {
        config()->set('media.disk', 'public');
        Storage::fake('public');
        Storage::disk('public')->put('featured-images/orphan.jpg', 'orphan');

        $this->artisan('media:audit --delete-orphans')
            ->expectsOutputToContain('requires the --force option')
            ->assertFailed();

        $this->artisan('media:audit --delete-orphans --force')
            ->assertSuccessful();

        Storage::disk('public')->assertMissing('featured-images/orphan.jpg');
    }
}
