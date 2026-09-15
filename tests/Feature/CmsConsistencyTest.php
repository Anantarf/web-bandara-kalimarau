<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Page;
use App\Models\Post;
use App\Models\PublicServiceLink;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CmsConsistencyTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_cms_slugs_are_normalized_before_saving(): void
    {
        $author = User::factory()->create();

        $page = Page::create([
            'title' => 'Profil Bandara',
            'slug' => 'Profil Bandara Kalimarau!!',
            'status' => 'draft',
            'template' => 'default',
        ]);

        $post = Post::create([
            'title' => 'Berita Bandara',
            'slug' => 'Berita Baru Kalimarau!!',
            'content' => 'Isi berita.',
            'status' => 'draft',
            'author_id' => $author->id,
        ]);

        $category = Category::create([
            'name' => 'Berita Utama',
            'slug' => 'Berita Utama!!',
            'sort_order' => 0,
        ]);

        $link = PublicServiceLink::create([
            'title' => 'SP4N LAPOR',
            'slug' => 'SP4N LAPOR!!',
            'url' => 'https://www.lapor.go.id',
            'category' => 'Pengaduan',
            'is_external' => true,
            'is_active' => true,
        ]);

        $this->assertSame('profil-bandara-kalimarau', $page->slug);
        $this->assertSame('berita-baru-kalimarau', $post->slug);
        $this->assertSame('berita-utama', $category->slug);
        $this->assertSame('sp4n-lapor', $link->slug);
    }

    public function test_admin_username_is_normalized_before_saving(): void
    {
        $user = User::factory()->create([
            'username' => 'Admin Konten Baru!!',
            'email' => null,
        ]);

        $this->assertSame('admin.konten.baru', $user->username);
        $this->assertSame('admin.konten.baru@kalimarau.local', $user->email);
    }
}
