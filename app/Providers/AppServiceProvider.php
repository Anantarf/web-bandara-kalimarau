<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\ContactMessage;
use App\Models\FlightSchedule;
use App\Models\Media;
use App\Models\Page;
use App\Models\Post;
use App\Models\PublicServiceLink;
use App\Models\Redirect;
use App\Models\User;
use App\Observers\AuditLogObserver;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

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
    }
}
