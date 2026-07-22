<?php

namespace Tests\Feature;

use App\Models\Facility;
use App\Models\Page;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPagesSmokeTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_loads(): void
    {
        $this->get(route('home'))->assertOk();
    }

    public function test_posts_index_loads_with_no_posts(): void
    {
        $this->get(route('posts.index'))->assertOk();
    }

    public function test_posts_index_loads_with_a_published_post(): void
    {
        Post::create([
            'title' => 'Berita Smoke Test',
            'slug' => 'berita-smoke-test',
            'content' => '<p>Konten.</p>',
            'status' => 'published',
            'published_at' => now(),
        ]);

        $this->get(route('posts.index'))->assertOk()->assertSee('Berita Smoke Test');
    }

    public function test_flights_index_loads_with_no_schedules(): void
    {
        $this->get(route('flights.index'))->assertOk();
    }

    public function test_contact_page_loads(): void
    {
        $this->get(route('contact.index'))->assertOk();
    }

    public function test_faq_page_loads(): void
    {
        $this->get(route('faq'))->assertOk();
    }

    public function test_search_page_loads_without_a_query(): void
    {
        $this->get(route('search'))->assertOk();
    }

    public function test_ppid_index_loads(): void
    {
        Page::create([
            'title' => 'PPID',
            'slug' => 'ppid',
            'content' => '<p>Konten PPID.</p>',
            'status' => 'published',
            'published_at' => now(),
        ]);

        $this->get(route('ppid.show'))->assertOk();
    }

    public function test_ppid_sub_page_loads_and_404s_for_unknown_sub(): void
    {
        Page::create([
            'title' => 'Profil PPID',
            'slug' => 'profile-ppid',
            'content' => '<p>Konten profil.</p>',
            'status' => 'published',
            'published_at' => now(),
        ]);

        $this->get(route('ppid.show', 'profil'))->assertOk()->assertSee('Profil PPID');
        $this->get(route('ppid.show', 'sub-yang-tidak-ada'))->assertStatus(404);
    }

    public function test_static_page_loads_by_slug(): void
    {
        Page::create([
            'title' => 'Halaman Statis Uji',
            'slug' => 'halaman-statis-uji',
            'content' => '<p>Konten halaman statis.</p>',
            'status' => 'published',
            'published_at' => now(),
        ]);

        $this->get(route('pages.show', 'halaman-statis-uji'))->assertOk()->assertSee('Halaman Statis Uji');
    }

    public function test_fasilitas_page_renders_facility_grid_from_database(): void
    {
        Facility::create([
            'category' => 'Fasilitas Umum',
            'name' => 'Mushola',
            'image' => 'facilities/mushola.jpg',
            'details' => ['Ruang ibadah yang bersih dan nyaman.'],
            'order' => 0,
        ]);

        Page::create([
            'title' => 'Fasilitas Bandara',
            'slug' => 'fasilitas-bandara',
            'content' => '<p>Konten fasilitas.</p>',
            'status' => 'published',
            'published_at' => now(),
        ]);

        $this->get(route('pages.show', 'fasilitas-bandara'))
            ->assertOk()
            ->assertSee('Mushola')
            ->assertSee('storage/facilities/mushola.jpg', false);
    }

    public function test_unknown_page_slug_returns_404(): void
    {
        $this->get('/halaman-yang-tidak-pernah-ada')->assertStatus(404);
    }
}
