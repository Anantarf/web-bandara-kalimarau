<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Redirect as RedirectModel;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class PageController extends Controller
{
    /**
     * Nested PPID sub-slug (per docs/SITEMAP LARAVEL.md) => actual page slug.
     * The Page.slug column stays globally unique, so PPID sub-pages keep their
     * original imported slug in the DB and are only exposed at the short
     * /ppid/{sub} URL through this map.
     */
    public const PPID_MAP = [
        'profil' => 'profile-ppid',
        'visi-misi' => 'visi-misi-ppid',
        'tugas-dan-fungsi' => 'tugas-dan-fungsi',
        'struktur-organisasi' => 'struktur-organisasi',
        'struktur-organisasi-pelaksana-upt' => 'struktur-organisasi-ppid-pelaksana-upt',
        'regulasi' => 'regulasi',
        'informasi-berkala' => 'informasi-berkala',
        'informasi-setiap-saat' => 'informasi-setiap-saat',
        'informasi-serta-merta' => 'informasi-serta-merta',
        'formulir-pengajuan-informasi' => 'formulir-pengajuan-informasi',
        'maklumat-pelayanan-standar-biaya' => 'maklumat-pelayanan-dan-standar-biaya',
        'prosedur-permohonan-informasi' => 'prosedur-permohonan-informasi',
        'prosedur-keberatan-informasi' => 'prosedur-permohonan-keberatan-informasi',
        'prosedur-sengketa-informasi-publik' => 'prosedur-pengajuan-sengketa-informasi-publik',
        'kritik-saran' => 'kritik-saran',
    ];

    public function show($slug): Response|RedirectResponse
    {
        $page = Page::query()
            ->published()
            ->where('slug', $slug)
            ->first();

        if (! $page) {
            return $this->redirectOrFail('/'.$slug);
        }

        return response(view('pages.show', compact('page')));
    }

    /**
     * Old URLs that no longer match any route (posts moved under /berita,
     * pages that changed slug, etc) fall back to the redirects table before
     * 404ing — never overrides a route that already resolved normally.
     */
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

        return view('pages.ppid', [
            'page' => $page,
            'ppidMap' => self::PPID_MAP,
            'ppidTitles' => collect(self::PPID_MAP)->mapWithKeys(fn ($realSlug, $sub) => [$sub => $titles[$realSlug] ?? $sub]),
        ]);
    }
}
