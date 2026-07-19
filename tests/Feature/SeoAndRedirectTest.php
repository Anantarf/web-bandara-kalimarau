<?php

namespace Tests\Feature;

use App\Models\Page;
use App\Models\Post;
use App\Models\Redirect;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeoAndRedirectTest extends TestCase
{
    use RefreshDatabase;

    public function test_post_detail_renders_canonical_and_open_graph_metadata(): void
    {
        $post = Post::create([
            'title' => 'Berita Uji',
            'slug' => 'berita-uji',
            'content' => '<p>Konten berita uji untuk metadata.</p>',
            'status' => 'published',
            'seo_title' => 'Judul SEO Berita Uji',
            'seo_description' => 'Deskripsi SEO berita uji.',
            'published_at' => now(),
        ]);

        $response = $this->get(route('posts.show', $post->slug));

        $response->assertOk()
            ->assertSee('<title>Judul SEO Berita Uji - Bandara Kalimarau</title>', false)
            ->assertSee('<link rel="canonical" href="'.route('posts.show', $post->slug).'">', false)
            ->assertSee('<meta property="og:type" content="article">', false)
            ->assertSee('<meta property="og:description" content="Deskripsi SEO berita uji.">', false);
    }

    public function test_sitemap_contains_published_posts_and_pages(): void
    {
        $post = Post::create([
            'title' => 'Berita Sitemap',
            'slug' => 'berita-sitemap',
            'status' => 'published',
            'published_at' => now(),
        ]);

        $page = Page::create([
            'title' => 'Halaman Sitemap',
            'slug' => 'halaman-sitemap',
            'status' => 'published',
            'published_at' => now(),
        ]);

        $response = $this->get(route('sitemap'));

        $response->assertOk()
            ->assertHeader('Content-Type', 'application/xml')
            ->assertSee(route('posts.show', $post->slug), false)
            ->assertSee(route('pages.show', $page->slug), false);
    }

    public function test_fallback_redirect_does_not_override_valid_routes(): void
    {
        Redirect::create([
            'old_path' => '/old-news',
            'new_path' => '/berita/new-news',
            'status_code' => 301,
            'is_active' => true,
        ]);

        $this->get('/old-news')
            ->assertRedirect('/berita/new-news')
            ->assertStatus(301);

        $this->get(route('posts.index'))->assertOk();
    }
}
