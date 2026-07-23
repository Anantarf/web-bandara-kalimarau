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

        $jsonLdBlocks = [];
        preg_match_all('#<script type="application/ld\+json">(.*?)</script>#s', $response->getContent(), $matches);
        foreach ($matches[1] as $json) {
            $jsonLdBlocks[] = json_decode($json, true);
        }
        $this->assertNotEmpty($jsonLdBlocks, 'Expected at least one JSON-LD block on the post page.');
        foreach ($jsonLdBlocks as $block) {
            $this->assertNotNull($block, 'Each JSON-LD block must be valid JSON.');
        }
        $articleBlock = collect($jsonLdBlocks)->firstWhere('@type', 'Article');
        $this->assertNotNull($articleBlock, 'Expected an Article JSON-LD block.');
        $this->assertSame($post->title, $articleBlock['headline']);

        $breadcrumbBlock = collect($jsonLdBlocks)->firstWhere('@type', 'BreadcrumbList');
        $this->assertNotNull($breadcrumbBlock, 'Expected a BreadcrumbList JSON-LD block.');
        $this->assertSame($post->title, end($breadcrumbBlock['itemListElement'])['name']);

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

    public function test_faq_page_has_valid_faqpage_json_ld(): void
    {
        $response = $this->get(route('faq'));

        preg_match_all('#<script type="application/ld\+json">(.*?)</script>#s', $response->getContent(), $matches);
        $faqBlock = collect($matches[1])
            ->map(fn ($json) => json_decode($json, true))
            ->firstWhere('@type', 'FAQPage');

        $this->assertNotNull($faqBlock, 'Expected a FAQPage JSON-LD block on the FAQ page.');
        $this->assertNotEmpty($faqBlock['mainEntity']);
        $this->assertArrayHasKey('name', $faqBlock['mainEntity'][0]);
        $this->assertArrayHasKey('text', $faqBlock['mainEntity'][0]['acceptedAnswer']);
    }

    public function test_search_results_page_is_noindexed(): void
    {
        $this->get(route('search'))
            ->assertOk()
            ->assertSee('<meta name="robots" content="noindex, follow">', false);
    }

    public function test_posts_index_canonical_reflects_current_pagination_page(): void
    {
        $this->get(route('posts.index', ['page' => 2]))
            ->assertOk()
            ->assertSee('<link rel="canonical" href="'.route('posts.index', ['page' => 2]).'">', false);
    }
}
