<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MediaAuditCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_reports_missing_and_safe_to_review_media_without_deleting_files(): void
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
            ->expectsOutputToContain('Safe review files')
            ->expectsOutputToContain('featured-images/orphan.jpg')
            ->assertSuccessful();

        Storage::disk('public')->assertExists('featured-images/orphan.jpg');
    }

    public function test_it_protects_legacy_files_and_recognizes_inline_content_references(): void
    {
        config()->set('media.disk', 'public');
        Storage::fake('public');
        Storage::disk('public')->put('media/legacy/2022/10/protected.jpg', 'legacy');
        Storage::disk('public')->put('media/berita/inline.jpg', 'inline');
        Storage::disk('public')->put('featured-images/orphan.jpg', 'orphan');

        Post::create([
            'title' => 'Berita Inline',
            'slug' => 'berita-inline',
            'content' => '<img src="/storage/media/berita/inline.jpg">',
            'status' => 'draft',
        ]);

        $this->artisan('media:audit')
            ->expectsOutputToContain('Inline content references')
            ->expectsOutputToContain('Protected files')
            ->expectsOutputToContain('media/legacy/2022/10/protected.jpg')
            ->expectsOutputToContain('Safe review files')
            ->expectsOutputToContain('featured-images/orphan.jpg')
            ->assertSuccessful();

        Storage::disk('public')->assertExists('media/legacy/2022/10/protected.jpg');
        Storage::disk('public')->assertExists('media/berita/inline.jpg');
        Storage::disk('public')->assertExists('featured-images/orphan.jpg');
    }
}
