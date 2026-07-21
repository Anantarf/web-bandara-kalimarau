<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Auth\Login;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\View\PanelsRenderHook;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\HtmlString;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login(Login::class)
            ->brandLogo(fn () => new HtmlString('
                <div class="flex items-center gap-3">
                    <img src="'.asset('images/logo-blu.png').'" alt="Logo" class="h-8">
                    <div class="flex flex-col text-left" x-data="{}" x-show="$store.sidebar.isOpen" x-transition>
                        <span class="text-xl font-bold leading-none" style="color: #0c2d6b;">Bandara Kalimarau</span>
                        <span class="text-sm font-medium text-gray-500 mt-1 leading-none">Kab. Berau, Kaltim</span>
                    </div>
                </div>
            '))
            ->brandLogoHeight('3rem')
            ->favicon(asset('images/logo-blu.png'))
            ->sidebarFullyCollapsibleOnDesktop()
            ->darkMode(false)
            ->font('Plus Jakarta Sans')
            ->colors([
                'primary' => '#0c2d6b', // Navy
                'warning' => '#c8860a', // Gold
                'info' => '#1e6fb5', // Sky
                'gray' => [
                    50 => '#f5f7fb',
                    100 => '#eef2f8',
                    200 => '#e2e7f0',
                    300 => '#cbd5e1',
                    400 => '#94a3b8',
                    500 => '#5c657a',
                    600 => '#475569',
                    700 => '#334155',
                    800 => '#1a1e2c',
                    900 => '#091f4a',
                    950 => '#020617',
                ],
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->plugins([
                FilamentShieldPlugin::make(),
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->renderHook(
                PanelsRenderHook::HEAD_END,
                fn (): HtmlString => new HtmlString(<<<'HTML'
                    <style>
                        input:-webkit-autofill,
                        input:-webkit-autofill:hover,
                        input:-webkit-autofill:focus {
                            -webkit-text-fill-color: #091f4a;
                            -webkit-box-shadow: 0 0 0 1000px #fff inset;
                            box-shadow: 0 0 0 1000px #fff inset;
                            transition: background-color 9999s ease-in-out 0s;
                        }

                        /* Premium Login Page Background */
                        .fi-simple-layout {
                            background: url('/images/hero1.jpg') center/cover no-repeat !important;
                            position: relative;
                        }
                        .fi-simple-layout::before {
                            content: '';
                            position: absolute;
                            inset: 0;
                            background: linear-gradient(135deg, rgba(12, 45, 107, 0.85) 0%, rgba(200, 134, 10, 0.6) 100%);
                            z-index: 0;
                        }
                        .fi-simple-main {
                            position: relative;
                            z-index: 1;
                        }
                        
                        /* Center and stack logo on login page */
                        .fi-simple-main .fi-logo {
                            height: auto !important;
                            margin-bottom: 1rem !important;
                        }
                        .fi-simple-main .fi-logo > div {
                            flex-direction: column !important;
                            justify-content: center !important;
                            align-items: center !important;
                            gap: 0.75rem !important;
                        }
                        .fi-simple-main .fi-logo .flex-col {
                            align-items: center !important;
                            text-align: center !important;
                        }
                        .fi-simple-main .fi-logo img {
                            height: 4.5rem !important; /* Make it even larger when stacked */
                            width: auto !important;
                        }
                        .fi-simple-main .fi-logo .text-xl {
                            font-size: 1.5rem !important;
                            line-height: 1.2 !important;
                        }

                        /* Retouch Sidebar Background */
                        aside.fi-sidebar {
                            background-color: #f5f7fb !important; /* gray.50 (custom palette) */
                            border-right: 1px solid #e2e7f0;
                        }

                        /* =========================================
                           MICRO ANIMATIONS & INTERACTIVE EFFECTS
                           ========================================= */

                        /* 1. Sidebar Items - Slight push to right */
                        .fi-sidebar-item > a, .fi-sidebar-item > button {
                            transition: all 0.2s ease-in-out !important;
                        }
                        .fi-sidebar-item > a:hover, .fi-sidebar-item > button:hover {
                            transform: translateX(4px);
                        }

                        /* 2. Buttons - Slight scale & lift */
                        .fi-btn {
                            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
                        }
                        .fi-btn:hover {
                            transform: translateY(-1px) scale(1.02);
                            box-shadow: 0 10px 15px -3px rgba(12, 45, 107, 0.15), 0 4px 6px -4px rgba(12, 45, 107, 0.1);
                        }
                        .fi-btn:active {
                            transform: scale(0.97);
                        }

                        /* 3. Cards / Widgets - Float effect */
                        .fi-wi-stats-overview-stat, .fi-section, .fi-ta-record {
                            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
                        }
                        .fi-wi-stats-overview-stat:hover {
                            transform: translateY(-4px);
                            box-shadow: 0 12px 20px -5px rgba(0, 0, 0, 0.08), 0 8px 10px -6px rgba(0, 0, 0, 0.04);
                        }

                        /* 4. Table Rows - Highlight and subtle scale */
                        .fi-ta-row {
                            transition: all 0.2s ease-in-out !important;
                        }
                        .fi-ta-row:hover {
                            background-color: #f5f7fb !important;
                            transform: scale(1.002);
                            z-index: 10;
                            position: relative;
                            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
                        }

                        /* 5. Inputs - Glow effect */
                        .fi-input-wrp {
                            transition: all 0.2s ease-in-out !important;
                        }
                        .fi-input-wrp:focus-within {
                            transform: translateY(-1px);
                            box-shadow: 0 0 0 3px rgba(30, 111, 181, 0.2) !important;
                        }
                    </style>
                    HTML),
            )
            ->renderHook(
                PanelsRenderHook::AUTH_LOGIN_FORM_AFTER,
                fn (): HtmlString => new HtmlString('
                    <div class="text-center mt-4">
                        <a href="/" class="text-sm font-medium text-gray-500 hover:text-primary-600 transition-colors inline-flex items-center gap-2 fi-btn-link">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            Kembali ke Beranda Web
                        </a>
                    </div>
                ')
            );
    }
}
