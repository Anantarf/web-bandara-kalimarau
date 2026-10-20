<?php

namespace App\Providers;

use App\Models\Announcement;
use App\Models\Category;
use App\Models\ContactMessage;
use App\Models\Facility;
use App\Models\FlightSchedule;
use App\Models\Media;
use App\Models\Page;
use App\Models\Post;
use App\Models\PublicServiceLink;
use App\Models\Redirect;
use App\Models\SurveyReport;
use App\Models\User;
use App\Models\Visitor;
use App\Observers\AuditLogObserver;
use App\Services\ImageOptimizer;
use Filament\Forms\Components\BaseFileUpload;
use Filament\Forms\Components\FileUpload;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use League\Flysystem\UnableToCheckFileExistence;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->environment('production') || request()->server('HTTP_X_FORWARDED_PROTO') === 'https') {
            URL::forceScheme('https');
        }

        // Global automatic optimization for all image file uploads in Filament
        FileUpload::configureUsing(function (FileUpload $component): void {
            $component->imageResizeMode('contain')
                ->imageResizeTargetWidth('1600')
                ->imageResizeTargetHeight('1200')
                ->imageResizeUpscale(false);

            $component->saveUploadedFileUsing(static function (BaseFileUpload $component, $file): ?string {
                try {
                    if (! $file->exists()) {
                        return null;
                    }
                } catch (UnableToCheckFileExistence $exception) {
                    return null;
                }

                $storeMethod = $component->getVisibility() === 'public' ? 'storePubliclyAs' : 'storeAs';

                $storedPath = $file->{$storeMethod}(
                    $component->getDirectory(),
                    $component->getUploadedFileNameForStorage($file),
                    $component->getDiskName(),
                );

                if ($storedPath) {
                    $ext = strtolower(pathinfo($storedPath, PATHINFO_EXTENSION));
                    if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp'], true)) {
                        $disk = $component->getDiskName() ?: config('filesystems.default', 'public');
                        $fullPath = Storage::disk($disk)->path($storedPath);
                        ImageOptimizer::optimize($fullPath);
                    }
                }

                return $storedPath;
            });
        });

        $observer = app(AuditLogObserver::class);

        foreach ([Category::class, ContactMessage::class, FlightSchedule::class, Media::class, Page::class, Post::class, PublicServiceLink::class, Redirect::class, User::class] as $model) {
            $model::observe($observer);
        }

        RateLimiter::for('contact-form', function (Request $request) {
            return Limit::perMinute(3)->by($request->ip());
        });

        RateLimiter::for('search', function (Request $request) {
            return Limit::perMinute(10)->by($request->ip());
        });

        View::composer('components.public.announcement-banner', function ($view) {
            $view->with('activeAnnouncements', Announcement::active()
                ->orderBy('sort_order')
                ->orderByDesc('id')
                ->get());
        });
        View::composer('components.fasilitas-grid', function ($view) {
            $categories = Facility::query()
                ->orderBy('order')
                ->get()
                ->groupBy('category')
                ->sortBy(fn ($items, $title) => $title === 'Aksesibilitas' ? 0 : 1)
                ->map(fn ($items, $title) => [
                    'title' => $title === 'Aksesibilitas' ? 'Sarana Bagi Kelompok Rentan' : $title,
                    'description' => $title === 'Aksesibilitas'
                        ? 'Fasilitas aksesibilitas untuk mendukung difabel, lansia, ibu hamil, anak-anak, dan pengguna jasa yang membutuhkan pendampingan.'
                        : null,
                    'is_featured_accessibility' => $title === 'Aksesibilitas',
                    'items' => $items->map(fn ($facility) => [
                        'name' => $facility->name,
                        'image' => $facility->image_url,
                        'details' => $facility->details ?? [],
                    ])->values(),
                ])
                ->values();

            $view->with('categories', $categories);
        });
        View::composer('pages.partials.hasil-dan-tindak-lanjut', function ($view) {
            $view->with('reports', SurveyReport::published()
                ->orderBy('sort_order')
                ->orderByDesc('period_date')
                ->get());
        });
        View::composer('components.public.footer', function ($view) {
            $stats = Cache::remember('visitor_stats', 60 * 5, function () {
                return [
                    'total' => Visitor::count(),
                ];
            });
            $view->with('visitorStats', $stats);
        });
    }
}
