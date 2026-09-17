<?php

namespace App\Http\Controllers;

use App\Models\Award;
use App\Models\Page;
use App\Models\PpidDocument;
use App\Models\Redirect as RedirectModel;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class PageController extends Controller
{
    /**
     * Nested PPID sub-slug (per docs/archive/SITEMAP LARAVEL.md) => actual page slug.
     * The Page.slug column stays globally unique, so PPID sub-pages keep their
     * original imported slug in the DB and are only exposed at the short
     * /ppid/{sub} URL through this map.
     */
    public const PPID_MAP = [
        'profil' => 'profile-ppid',
        'visi-misi' => 'visi-misi-ppid',
        'tugas-dan-fungsi' => 'tugas-dan-fungsi',
        'struktur-organisasi' => 'struktur-organisasi-ppid-pelaksana-upt',
        'regulasi' => 'regulasi',
        'maklumat-pelayanan-standar-biaya' => 'maklumat-pelayanan-dan-standar-biaya',
        'informasi-berkala' => 'informasi-berkala',
        'informasi-setiap-saat' => 'informasi-setiap-saat',
        'informasi-serta-merta' => 'informasi-serta-merta',
        'formulir-pengajuan-informasi' => 'formulir-pengajuan-informasi',
        'prosedur-permohonan-informasi' => 'prosedur-permohonan-informasi',
        'prosedur-keberatan-informasi' => 'prosedur-permohonan-keberatan-informasi',
        'prosedur-sengketa-informasi-publik' => 'prosedur-pengajuan-sengketa-informasi-publik',
        'kritik-saran' => 'kritik-saran',
    ];

    public function show($slug): Response|RedirectResponse
    {
        if ($ppidSub = self::ppidSubForPageSlug($slug)) {
            return redirect()->route('ppid.show', $ppidSub, 301);
        }

        $page = Page::query()
            ->published()
            ->where('slug', $slug)
            ->first();

        if (! $page) {
            return $this->redirectOrFail('/'.$slug);
        }

        $profileAwards = $page->slug === 'profil-bandara-kalimarau'
            ? Award::published()->ordered()->get()
            : collect();

        return response(view('pages.show', compact('page', 'profileAwards')));
    }

    public static function ppidSubForPageSlug(string $slug): ?string
    {
        $sub = array_search($slug, self::PPID_MAP, true);

        return $sub === false ? null : $sub;
    }

    /**
     * Old URLs that no longer match any route (posts moved under /berita,
     * pages that changed slug, etc) fall back to the redirects table before
     * 404ing - never overrides a route that already resolved normally.
     */
    public function fallback(\Illuminate\Http\Request $request): Response|RedirectResponse
    {
        return $this->redirectOrFail('/'.trim($request->path(), '/'));
    }

    protected function redirectOrFail(string $oldPath): Response|RedirectResponse
    {
        $redirect = RedirectModel::where('old_path', $oldPath)->where('is_active', true)->first();

        if ($redirect) {
            return redirect($redirect->new_path, $redirect->status_code);
        }

        abort(404);
    }

    public function ppid(?string $sub = null)
    {
        $realSlug = $sub === null ? 'ppid' : (self::PPID_MAP[$sub] ?? abort(404));

        $page = Page::published()->where('slug', $realSlug)->firstOrFail();

        $titles = Page::published()->whereIn('slug', self::PPID_MAP)->pluck('title', 'slug');
        $ppidDocuments = PpidDocument::query()
            ->published()
            ->where('category', $sub)
            ->orderBy('sort_order')
            ->latest('published_at')
            ->get();

        return view('pages.ppid', [
            'page' => $page,
            'ppidMap' => self::PPID_MAP,
            'ppidTitles' => collect(self::PPID_MAP)->mapWithKeys(fn ($realSlug, $sub) => [$sub => $titles[$realSlug] ?? $sub]),
            'ppidDocuments' => $ppidDocuments,
        ]);
    }
}
