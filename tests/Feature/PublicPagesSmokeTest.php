<?php

namespace Tests\Feature;

use App\Models\Facility;
use App\Models\Page;
use App\Models\Post;
use App\Models\PpidDocument;
use Database\Seeders\PageSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
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
        $this->seed(PageSeeder::class);

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

    public function test_consolidated_pages_redirect_with_301(): void
    {
        Page::create([
            'title' => 'Hasil dan Tindak Lanjut',
            'slug' => 'hasil-dan-tindak-lanjut',
            'content' => '<p>Hasil</p>',
            'status' => 'published',
            'published_at' => now(),
        ]);

        $this->get(route('pages.show', 'hasil-dan-tindak-lanjut'))
            ->assertStatus(301)
            ->assertRedirect(route('pages.show', 'survey-kepuasan-masyarakat-internal').'#hasil-survei');

        $this->get(route('ppid.show', 'visi-misi'))
            ->assertStatus(301)
            ->assertRedirect(route('ppid.show', 'profil').'#visi-misi');
    }

    public function test_simadu_and_sp4n_lapor_pages_load(): void
    {
        Page::create([
            'title' => 'SIMADU',
            'slug' => 'simadu',
            'content' => '<p>SIMADU</p>',
            'status' => 'published',
            'published_at' => now(),
        ]);

        Page::create([
            'title' => 'SP4N LAPOR',
            'slug' => 'sp4n-lapor',
            'content' => '<p>SP4N LAPOR</p>',
            'status' => 'published',
            'published_at' => now(),
        ]);

        $this->get(route('pages.show', 'simadu'))->assertOk();
        $this->get(route('pages.show', 'sp4n-lapor'))->assertOk();
    }

    public function test_ppid_sub_page_renders_only_published_documents_for_current_category(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('ppid-documents/laporan-kinerja-2026.pdf', 'pdf');

        Page::create([
            'title' => 'Informasi Berkala',
            'slug' => 'informasi-berkala',
            'content' => '<p>Konten informasi berkala.</p>',
            'status' => 'published',
            'published_at' => now(),
        ]);

        PpidDocument::create([
            'title' => 'Laporan Kinerja 2026',
            'description' => 'Dokumen kinerja tahunan.',
            'category' => 'informasi-berkala',
            'file_path' => 'ppid-documents/laporan-kinerja-2026.pdf',
            'is_active' => true,
            'published_at' => now()->subDay(),
            'sort_order' => 1,
        ]);

        PpidDocument::create([
            'title' => 'Dokumen Nonaktif',
            'category' => 'informasi-berkala',
            'file_path' => 'ppid-documents/nonaktif.pdf',
            'is_active' => false,
            'published_at' => now()->subDay(),
        ]);

        PpidDocument::create([
            'title' => 'Dokumen Kategori Lain',
            'category' => 'regulasi',
            'file_path' => 'ppid-documents/regulasi.pdf',
            'is_active' => true,
            'published_at' => now()->subDay(),
        ]);

        PpidDocument::create([
            'title' => 'Dokumen Terjadwal',
            'category' => 'informasi-berkala',
            'file_path' => 'ppid-documents/terjadwal.pdf',
            'is_active' => true,
            'published_at' => now()->addDay(),
        ]);

        $this->get(route('ppid.show', 'informasi-berkala'))
            ->assertOk()
            ->assertSee('Laporan Kinerja 2026')
            ->assertSee('Dokumen kinerja tahunan.')
            ->assertSee('storage/ppid-documents/laporan-kinerja-2026.pdf', false)
            ->assertDontSee('Dokumen Nonaktif')
            ->assertDontSee('Dokumen Kategori Lain')
            ->assertDontSee('Dokumen Terjadwal');
    }

    public function test_ppid_sub_page_does_not_render_missing_document_files(): void
    {
        Storage::fake('public');

        Page::create([
            'title' => 'Informasi Berkala',
            'slug' => 'informasi-berkala',
            'content' => '<p>Konten informasi berkala.</p>',
            'status' => 'published',
            'published_at' => now(),
        ]);

        PpidDocument::create([
            'title' => 'Dokumen Hilang',
            'description' => 'Path file tidak tersedia.',
            'category' => 'informasi-berkala',
            'file_path' => 'ppid-documents/hilang.pdf',
            'is_active' => true,
            'published_at' => now()->subDay(),
            'sort_order' => 1,
        ]);

        $this->get(route('ppid.show', 'informasi-berkala'))
            ->assertOk()
            ->assertDontSee('Dokumen Hilang')
            ->assertDontSee('storage/ppid-documents/hilang.pdf', false)
            ->assertSee('Belum ada dokumen PPID yang tersedia.');
    }

    public function test_standar_pelayanan_seeded_page_loads(): void
    {
        $this->seed(PageSeeder::class);

        $this->get(route('pages.show', 'standar-pelayanan'))
            ->assertOk()
            ->assertSee('Standar Pelayanan')
            ->assertSee('storage/media/legacy/2024/09/Standar-Pelayanan-2023.pdf', false);
    }

    public function test_pengajuan_pas_bandara_seeded_page_loads(): void
    {
        $this->seed(PageSeeder::class);

        $this->get(route('pages.show', 'pengajuan-pas-bandara'))
            ->assertOk()
            ->assertSee('Pengajuan Pas Bandara')
            ->assertSee('alur-pembuatan-pas-bandara.png', false);
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
