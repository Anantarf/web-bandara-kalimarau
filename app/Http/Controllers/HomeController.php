<?php

namespace App\Http\Controllers;

use App\Models\Airline;
use App\Models\AirportStat;
use App\Models\Facility;
use App\Models\FlightSchedule;
use App\Models\Post;
use App\Models\PublicServiceLink;

class HomeController extends Controller
{
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

        $heroImages = collect(config('home.hero_images'))->map(fn ($path) => asset($path))->toArray();
        $facilities = Facility::query()
            ->orderBy('order')
            ->take(4)
            ->get()
            ->map(fn (Facility $facility) => [
                'title' => $facility->name,
                'desc' => ! empty($facility->details[0]) ? $facility->details[0] : 'Layanan fasilitas terminal untuk kenyamanan dan kemudahan pengguna jasa.',
                'img' => $facility->image_url,
            ]);
        $sambutan = config('home.welcome');
        $dbMitra = Airline::query()
            ->active()
            ->ordered()
            ->get()
            ->map(fn (Airline $airline) => [
                'nama' => $airline->name,
                'rute' => $airline->routes,
                'logo' => $airline->logo_url,
                'slug' => $airline->slug,
            ])
            ->toArray();

        $mitra = ! empty($dbMitra) ? $dbMitra : collect(config('home.partner_fallbacks'))->map(fn ($item) => [
            'nama' => $item['nama'],
            'rute' => $item['rute'],
            'logo' => asset($item['logo']),
            'slug' => $item['slug'],
        ])->toArray();

        return view('home', compact('latestPosts', 'flightSchedules', 'serviceLinks', 'airportStat', 'heroImages', 'facilities', 'sambutan', 'mitra'));
    }
}
