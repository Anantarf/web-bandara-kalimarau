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
                'loc' => $this->pageCanonicalUrl($page),
                'lastmod' => $page->updated_at?->toAtomString(),
            ])
            ->unique('loc')
            ->values();

        return response()
            ->view('sitemap', ['urls' => $urls->merge($postUrls)->merge($pageUrls)->unique('loc')->values()])
            ->header('Content-Type', 'application/xml');
    }

    protected function pageCanonicalUrl(Page $page): string
    {
        if ($page->slug === 'hasil-dan-tindak-lanjut') {
            return route('pages.show', 'survey-kepuasan-masyarakat-internal');
        }

        $ppidSub = PageController::ppidSubForPageSlug($page->slug);

        if ($ppidSub) {
            if (in_array($ppidSub, ['visi-misi', 'tugas-dan-fungsi'], true)) {
                return route('ppid.show', 'profil');
            }

            return route('ppid.show', $ppidSub);
        }

        return route('pages.show', $page->slug);
    }
}
