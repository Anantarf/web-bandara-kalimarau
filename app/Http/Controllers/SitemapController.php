<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Post;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function __invoke(): Response
    {
        $urls = collect([
            (object) ['loc' => route('home'), 'lastmod' => null],
            (object) ['loc' => route('posts.index'), 'lastmod' => null],
            (object) ['loc' => route('flights.index'), 'lastmod' => null],
            (object) ['loc' => route('contact.index'), 'lastmod' => null],
            (object) ['loc' => route('search'), 'lastmod' => null],
        ]);

        $postUrls = Post::query()
            ->published()
            ->select(['slug', 'updated_at'])
            ->latest('updated_at')
            ->get()
            ->map(fn (Post $post) => (object) [
                'loc' => route('posts.show', $post->slug),
                'lastmod' => $post->updated_at?->toAtomString(),
            ]);

        $pageUrls = Page::query()
            ->published()
            ->select(['slug', 'updated_at'])
            ->latest('updated_at')
            ->get()
            ->map(fn (Page $page) => (object) [
                'loc' => route('pages.show', $page->slug),
                'lastmod' => $page->updated_at?->toAtomString(),
            ]);

        return response()
            ->view('sitemap', ['urls' => $urls->merge($postUrls)->merge($pageUrls)])
            ->header('Content-Type', 'application/xml');
    }
}
