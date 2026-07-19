<?php

namespace App\Http\Controllers;

use App\Models\AirportStat;
use App\Models\FlightSchedule;
use App\Models\Post;
use App\Models\PublicServiceLink;

class HomeController extends Controller
{
    /**
     * Fixed, hand-picked images for the hero carousel and facilities cards.
     *
     * Deliberately NOT pulled from the `media` table: that table holds every
     * image imported from the legacy site (news photos, holiday greetings,
     * scam warnings, tax socialization posters, staff portraits...) with no
     * curation flag to tell "airport photography" apart from "whatever image
     * was attached to this news post". A random/featured-image query over
     * that table can surface anything — including a QRIS payment code or an
     * HIV/AIDS awareness poster — as the homepage hero. Until there's a real
     * curation mechanism (e.g. an admin-set `is_featured_photo` flag on
     * Media), stock photography is the safe choice here.
     */
    protected const HERO_IMAGES = [
        'https://images.unsplash.com/photo-1436491865332-7a61a109cc05?q=80&w=2074&auto=format&fit=crop',
        'https://images.unsplash.com/photo-1705322883689-e0ce95308103?w=1600&h=900&fit=crop&auto=format',
        'https://images.unsplash.com/photo-1544281678-75f106460459?q=80&w=1600&auto=format&fit=crop',
    ];

    protected const FACILITIES = [
        [
            'title' => 'Ruang Tunggu Eksekutif',
            'desc' => 'Kenyamanan ekstra dengan makanan ringan dan minuman gratis.',
            'img' => 'https://images.unsplash.com/photo-1542296332-2e4473faf563?q=80&w=600&auto=format&fit=crop',
        ],
        [
            'title' => 'Area Komersial',
            'desc' => 'Toko suvenir dan produk lokal khas Kalimantan Timur.',
            'img' => 'https://images.unsplash.com/photo-1555626906-fcf10d6851b4?q=80&w=600&auto=format&fit=crop',
        ],
        [
            'title' => 'Ruang Laktasi',
            'desc' => 'Ruang khusus yang nyaman untuk ibu menyusui dan bayi.',
            'img' => 'https://images.unsplash.com/photo-1563298723-dcfebaa392e3?q=80&w=600&auto=format&fit=crop',
        ],
        [
            'title' => 'Restoran & Kafe',
            'desc' => 'Beragam pilihan hidangan lokal dan internasional.',
            'img' => 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?q=80&w=600&auto=format&fit=crop',
        ],
    ];

    protected const SAMBUTAN = [
        'nama' => 'Budi Raharjo',
        'jabatan' => 'Kepala UPBU Kelas I Kalimarau',
        'teks' => [
            'Selamat datang di portal resmi Bandara Kalimarau. Di tengah kebutuhan informasi yang semakin cepat, kami menghadirkan website ini sebagai kanal resmi untuk membantu masyarakat memperoleh informasi layanan bandara secara mudah, jelas, dan tepercaya.',
            'Kami terus berkomitmen memberikan pelayanan terbaik dengan mengutamakan keselamatan, keamanan, dan kenyamanan pengguna jasa penerbangan. Melalui website ini, masyarakat dapat mengakses informasi penerbangan, layanan publik, berita, kontak, serta kanal pengaduan secara lebih terarah.',
            'Kami mengundang masyarakat untuk memanfaatkan situs ini sebagai sarana informasi dan komunikasi. Masukan yang konstruktif akan menjadi bagian penting dalam meningkatkan kualitas pelayanan Bandara Kalimarau bagi Kabupaten Berau dan wilayah sekitarnya.',
        ],
        'foto' => 'https://images.unsplash.com/photo-1560250097-0b93528c311a?q=80&w=256&auto=format&fit=crop',
    ];

    protected const MITRA = [
        [
            'nama' => 'Batik Air',
            'rute' => 'Jakarta (CGK), Surabaya (SUB)',
            'logo' => 'images/airlines/batik-air.svg',
            'slug' => 'batik-air',
        ],
        [
            'nama' => 'Super Air Jet',
            'rute' => 'Balikpapan (BPN), Surabaya (SUB)',
            'logo' => 'images/airlines/super-air-jet.svg',
            'slug' => 'super-air-jet',
        ],
        [
            'nama' => 'AirAsia',
            'rute' => 'Surabaya (SUB)',
            'logo' => 'images/airlines/airasia.svg',
            'slug' => 'airasia',
        ],
        [
            'nama' => 'Sriwijaya Air',
            'rute' => 'Balikpapan (BPN), Makassar (UPG)',
            'logo' => 'images/airlines/sriwijaya-air.png',
            'slug' => 'sriwijaya-air',
        ],
        [
            'nama' => 'Citilink',
            'rute' => 'Balikpapan (BPN)',
            'logo' => 'images/airlines/citilink.svg',
            'slug' => 'citilink',
        ],
        [
            'nama' => 'Wings Air',
            'rute' => 'Samarinda (AAP), Balikpapan (BPN), Maratua (RTU)',
            'logo' => 'images/airlines/wings-air.svg',
            'slug' => 'wings-air',
        ],
        [
            'nama' => 'Smart Aviation',
            'rute' => 'Maratua (RTU)',
            'logo' => 'images/airlines/smart-aviation.png',
            'slug' => 'smart-aviation',
        ],
    ];

    public function index()
    {
        $latestPosts = Post::query()
            ->published()
            ->latest('published_at')
            ->take(5)
            ->get();

        $today = strtolower(now()->locale('id')->dayName);
        $flightSchedules = FlightSchedule::query()
            ->active()
            ->whereJsonContains('days', $today)
            ->orderBy('sort_order')
            ->take(10)
            ->get();

        $serviceLinks = PublicServiceLink::query()
            ->active()
            ->orderBy('sort_order')
            ->get();

        $airportStat = AirportStat::query()
            ->where('is_active', true)
            ->latest('period_date')
            ->first();

        $heroImages = self::HERO_IMAGES;
        $facilities = self::FACILITIES;
        $sambutan = self::SAMBUTAN;
        $mitra = self::MITRA;

        return view('home', compact('latestPosts', 'flightSchedules', 'serviceLinks', 'airportStat', 'heroImages', 'facilities', 'sambutan', 'mitra'));
    }
}
