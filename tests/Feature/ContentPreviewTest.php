<?php

namespace Tests\Feature;

use App\Models\Page;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class ContentPreviewTest extends TestCase
{
    use RefreshDatabase;

    public function test_signed_preview_displays_draft_content_without_exposing_it_publicly(): void
    {
        $post = Post::create([
            'title' => 'Berita Draft',
            'slug' => 'berita-draft',
            'status' => 'draft',
            'content' => '<p>Konten internal.</p>',
        ]);

        $previewUrl = URL::temporarySignedRoute('posts.preview', now()->addMinutes(30), ['post' => $post]);

        $this->get($previewUrl)
            ->assertOk()
            ->assertSee('Pratinjau admin')
            ->assertSee('Konten internal.')
            ->assertSee('<meta name="robots" content="noindex, nofollow">', false);

        $this->get(route('posts.show', $post->slug))->assertNotFound();
    }

    public function test_preview_requires_a_valid_signature(): void
    {
        $page = Page::create([
            'title' => 'Halaman Draft',
            'slug' => 'halaman-draft',
            'status' => 'draft',
        ]);

        $this->get(route('pages.preview', $page))->assertForbidden();
    }
}
