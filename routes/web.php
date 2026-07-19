<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\FlightScheduleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PreviewController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SitemapController;
use App\Models\Redirect;
use Illuminate\Http\Request;
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

// PPID (nested per docs/SITEMAP LARAVEL.md, must come before the catch-all below)
Route::get('/ppid/{sub?}', [PageController::class, 'ppid'])->name('ppid.show');

// Halaman Statis (Catch-all for pages, should be at the bottom)
Route::get('/{slug}', [PageController::class, 'show'])->name('pages.show');

// Old multi-segment URLs that match no route above (e.g. trailing slashes,
// old nested paths) - checked against the redirects table, then 404.
Route::fallback(function (Request $request) {
    $redirect = Redirect::where('old_path', '/'.trim($request->path(), '/'))
        ->where('is_active', true)
        ->first();

    abort_if(! $redirect, 404);

    return redirect($redirect->new_path, $redirect->status_code);
});
