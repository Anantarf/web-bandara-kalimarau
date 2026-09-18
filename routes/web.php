<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\FlightScheduleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PreviewController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

// Homepage
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/sitemap.xml', SitemapController::class)->name('sitemap');

// Search (with rate limit)
Route::get('/search', [SearchController::class, 'index'])
    ->middleware('throttle:search')
    ->name('search');

// Jadwal Penerbangan
Route::get('/jadwal-penerbangan', [FlightScheduleController::class, 'index'])->name('flights.index');
Route::redirect('/penerbangan', '/jadwal-penerbangan', 301);
Route::redirect('/idpas', '/pengajuan-pas-bandara', 301);

// Kontak (with rate limit on POST)
Route::get('/kontak', [ContactController::class, 'index'])->name('contact.index');
Route::post('/kontak', [ContactController::class, 'store'])
    ->middleware('throttle:contact-form')
    ->name('contact.store');

Route::get('/preview/berita/{post}', [PreviewController::class, 'post'])
    ->middleware('signed')
    ->name('posts.preview');

Route::get('/preview/halaman/{page}', [PreviewController::class, 'page'])
    ->middleware('signed')
    ->name('pages.preview');

// Berita
Route::prefix('berita')->name('posts.')->group(function () {
    Route::get('/', [PostController::class, 'index'])->name('index');
    Route::get('/{slug}', [PostController::class, 'show'])->name('show');
});

// PPID (nested per docs/archive/SITEMAP LARAVEL.md, must come before the catch-all below)
Route::get('/ppid/{sub?}', [PageController::class, 'ppid'])->name('ppid.show');
Route::redirect('/informasi/berkala', '/ppid/informasi-berkala', 301);
Route::redirect('/informasi/setiap-saat', '/ppid/informasi-setiap-saat', 301);
Route::redirect('/informasi/serta-merta', '/ppid/informasi-serta-merta', 301);

// FAQ
Route::view('/faq', 'faq')->name('faq');

// Halaman Statis (Catch-all for pages, should be at the bottom)
Route::get('/{slug}', [PageController::class, 'show'])->name('pages.show');

// Old multi-segment URLs that match no route above (e.g. trailing slashes,
// old nested paths) - checked against the redirects table, then 404.
Route::fallback([PageController::class, 'fallback']);
