<?php

namespace Tests\Feature;

use App\Models\Page;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ScheduledContentTest extends TestCase
{
    use RefreshDatabase;

    public function test_future_published_content_is_hidden_until_its_publish_time(): void
    {
        $publishAt = now()->addDay();

        $post = Post::create([
            'title' => 'Berita Terjadwal',
            'slug' => 'berita-terjadwal',
            'status' => 'published',
            'published_at' => $publishAt,
        ]);

        $page = Page::create([
            'title' => 'Halaman Terjadwal',
            'slug' => 'halaman-terjadwal',
            'status' => 'published',
            'published_at' => $publishAt,
        ]);

        $this->assertFalse(Post::published()->whereKey($post)->exists());
        $this->assertFalse(Page::published()->whereKey($page)->exists());

        $this->travelTo($publishAt->copy()->addMinute());

        $this->assertTrue(Post::published()->whereKey($post)->exists());
        $this->assertTrue(Page::published()->whereKey($page)->exists());
    }
}
