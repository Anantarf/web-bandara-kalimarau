<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Auth\Login;
use App\Filament\Pages\Dashboard;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\MenuItem;
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
                    <div class="kalimarau-brand-text flex flex-col text-left">
                        <span class="text-xl font-bold leading-none" style="color: #0c2d6b;">Bandara Kalimarau</span>
                        <span class="text-sm font-medium text-gray-500 mt-1 leading-none">Kab. Berau, Kaltim</span>
                    </div>
                </div>
            '))
            ->brandLogoHeight('3rem')
            ->favicon(asset('images/logo-blu.png'))
            ->sidebarFullyCollapsibleOnDesktop()
            ->globalSearchKeyBindings(['command+k', 'ctrl+k'])
            ->userMenuItems([
                MenuItem::make()
                    ->label('Lihat Portal Utama')
                    ->url('/')
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->openUrlInNewTab(),
            ])
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
                Dashboard::class,
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

                        /* Compact 1-Page Non-Scrollable Login Layout with Airport View Background */
                        html,
                        body.fi-body-has-no-sidebar {
                            height: 100% !important;
                            max-height: 100vh !important;
                            overflow: hidden !important;
                            margin: 0 !important;
                            padding: 0 !important;
                            background: #061838 !important;
                        }
                        body.fi-body-has-no-sidebar::before {
                            content: '';
                            position: fixed;
                            inset: -1.5rem;
                            z-index: 0;
                            pointer-events: none;
                            background: url('/images/hero/hero1.jpg') center/cover no-repeat;
                            filter: blur(4px) brightness(0.65) saturate(1.2);
                            transform: scale(1.05);
                            opacity: 0.85;
                        }
                        body.fi-body-has-no-sidebar::after {
                            content: '';
                            position: fixed;
                            inset: 0;
                            z-index: 0;
                            pointer-events: none;
                            background: linear-gradient(135deg, rgba(6, 24, 56, 0.72) 0%, rgba(12, 45, 107, 0.5) 50%, rgba(6, 24, 56, 0.78) 100%);
                        }

                        body.fi-body-has-no-sidebar .fi-simple-layout {
                            height: 100vh !important;
                            max-height: 100vh !important;
                            width: 100% !important;
                            max-width: 100% !important;
                            overflow: hidden !important;
                            margin: 0 !important;
                            padding: 1rem !important;
                            box-sizing: border-box !important;
                            display: flex !important;
                            flex-direction: column !important;
                            justify-content: center !important;
                            align-items: center !important;
                            position: relative !important;
                            isolation: isolate !important;
                            background: transparent !important;
                        }
                        .fi-simple-main {
                            position: relative;
                            z-index: 10;
                            background-color: rgba(255, 255, 255, 0.96) !important;
                            border-radius: 1rem !important;
                            box-shadow: 0 1.25rem 2.5rem -0.75rem rgba(2, 6, 23, 0.55), 0 0 0 1px rgba(255, 255, 255, 0.25) !important;
                            border: 1px solid rgba(226, 231, 240, 0.92) !important;
                            overflow: hidden !important;
                            padding: 1.625rem !important;
                            max-height: calc(100vh - 2rem) !important;
                            width: 100% !important;
                            max-width: 24rem !important;
                            box-sizing: border-box !important;
                        }
                        
                        /* Center and stack logo on login page */
                        .fi-simple-main .fi-logo {
                            height: auto !important;
                            margin-bottom: 0.618rem !important;
                        }
                        .fi-simple-main .fi-logo > div {
                            flex-direction: column !important;
                            justify-content: center !important;
                            align-items: center !important;
                            gap: 0.382rem !important;
                        }
                        .fi-simple-main .fi-logo .flex-col {
                            align-items: center !important;
                            text-align: center !important;
                        }
                        .fi-simple-main .fi-logo img {
                            height: 3.125rem !important;
                            width: auto !important;
                        }
                        .fi-simple-main .fi-logo .text-xl {
                            font-size: 1.125rem !important;
                            line-height: 1.18 !important;
                        }
                        .fi-simple-main .fi-logo .text-sm {
                            font-size: 0.75rem !important;
                            line-height: 1.35 !important;
                        }
                        /* Paksa tampilkan nama brand di login */
                        .fi-simple-main .fi-logo [x-show] {
                            display: flex !important;
                        }

                        /* Compact Form Headings & Controls */
                        .fi-simple-main h1,
                        .fi-simple-main h2,
                        .fi-simple-main .fi-simple-header-heading {
                            font-size: 1.375rem !important;
                            margin-top: 0.382rem !important;
                            margin-bottom: 1rem !important;
                            line-height: 1.18 !important;
                            letter-spacing: 0 !important;
                        }
                        .fi-simple-main form {
                            gap: 1rem !important;
                        }
                        .fi-simple-main .fi-form-actions {
                            margin-top: 1rem !important;
                        }
                        .fi-simple-main .fi-fo-field-wrp-label span,
                        .fi-simple-main .fi-fo-field-wrp-label label {
                            font-size: 0.875rem !important;
                            line-height: 1.35 !important;
                            color: #0f172a !important;
                            font-weight: 500 !important;
                        }
                        .fi-simple-main .fi-input-wrp {
                            min-height: 2.75rem !important;
                            border-radius: 0.75rem !important;
                        }
                        .fi-simple-main .fi-input {
                            min-height: 2.75rem !important;
                            font-size: 0.9375rem !important;
                            line-height: 1.5 !important;
                        }
                        .fi-simple-main .fi-input::placeholder {
                            color: #64748b !important;
                            opacity: 1 !important;
                        }
                        .fi-simple-main .fi-btn {
                            min-height: 2.75rem !important;
                            padding-top: 0.625rem !important;
                            padding-bottom: 0.625rem !important;
                            font-size: 0.9375rem !important;
                        }
                        .fi-simple-main .kalimarau-login-footer {
                            margin-top: 0.875rem !important;
                        }
                        .fi-simple-main .kalimarau-login-back {
                            font-size: 0.75rem !important;
                            line-height: 1.35 !important;
                        }
                        .fi-simple-main .kalimarau-login-credit {
                            margin-top: 0.625rem !important;
                            padding-top: 0.625rem !important;
                            font-size: 0.6875rem !important;
                            line-height: 1.45 !important;
                            color: #64748b !important;
                            letter-spacing: 0 !important;
                        }

                        /* Retouch Sidebar Background */
                        aside.fi-sidebar {
                            background-color: #f5f7fb !important; /* gray.50 (custom palette) */
                            border-right: 1px solid #e2e7f0;
                        }
                        aside.fi-sidebar:not(.fi-sidebar-open) .kalimarau-brand-text {
                            display: none !important;
                        }

                        /* =========================================
                           MICRO ANIMATIONS & INTERACTIVE EFFECTS
                           ========================================= */

                        /* 1. Sidebar Items - Slight push to right */
                        .fi-sidebar-item > a, .fi-sidebar-item > button {
                            transition: all 0.2s ease-in-out !important;
                        }
                        .fi-sidebar-item > a:hover, .fi-sidebar-item > button:hover {
                            background-color: #eef2f8;
                        }

                        /* 2. Buttons - restrained feedback */
                        .fi-btn {
                            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
                        }
                        .fi-btn:hover {
                            box-shadow: 0 4px 10px -6px rgba(12, 45, 107, 0.28);
                        }
                        .fi-btn:active {
                            transform: translateY(0);
                        }

                        /* 3. Cards / Widgets - restrained feedback */
                        .fi-wi-stats-overview-stat, .fi-section, .fi-ta-record {
                            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
                        }
                        .fi-wi-stats-overview-stat:hover {
                            box-shadow: 0 8px 14px -12px rgba(5, 19, 48, 0.22);
                        }

                        /* 4. Table Rows - Highlight */
                        .fi-ta-row {
                            transition: background-color 0.2s ease-in-out, box-shadow 0.2s ease-in-out !important;
                        }
                        .fi-ta-row:hover {
                            background-color: #f5f7fb !important;
                            box-shadow: inset 3px 0 0 #f2a900;
                        }

                        /* 5. Inputs - Glow effect & Stacking Context Fix */
                        .fi-fo-field-wrp, .fi-input-wrp {
                            min-width: 0 !important;
                        }
                        .fi-input-wrp {
                            transition: box-shadow 0.2s ease-in-out, border-color 0.2s ease-in-out !important;
                        }
                        .fi-input-wrp:focus-within {
                            box-shadow: 0 0 0 3px rgba(30, 111, 181, 0.2) !important;
                        }

                        /* Fix Dropdown & Popover Overlapping */
                        .fi-dropdown-panel,
                        .fi-select-input-options-ctn,
                        [x-ref="panel"] {
                            z-index: 80 !important;
                        }

                        /* =========================================
                           TIPTAP WYSIWYG REALTIME EDITOR STYLING
                           ========================================= */
                        .tiptap-wrapper .tiptap h1 {
                            font-size: 2rem !important;
                            font-weight: 800 !important;
                            color: #0c2d6b !important;
                            margin-top: 1.25rem !important;
                            margin-bottom: 0.5rem !important;
                        }
                        .tiptap-wrapper .tiptap h2 {
                            font-size: 1.5rem !important;
                            font-weight: 700 !important;
                            color: #0c2d6b !important;
                            margin-top: 1rem !important;
                            margin-bottom: 0.5rem !important;
                        }
                        .tiptap-wrapper .tiptap h3 {
                            font-size: 1.25rem !important;
                            font-weight: 600 !important;
                            color: #0c2d6b !important;
                            margin-top: 0.75rem !important;
                            margin-bottom: 0.5rem !important;
                        }
                        .tiptap-wrapper .tiptap p {
                            font-size: 1rem !important;
                            font-weight: 400 !important;
                            color: #334155 !important;
                            line-height: 1.6 !important;
                            margin-bottom: 0.75rem !important;
                        }
                        .tiptap-wrapper .tiptap p.lead {
                            font-size: 1.15rem !important;
                            font-weight: 500 !important;
                            color: #1e293b !important;
                        }
                        .tiptap-wrapper .tiptap small {
                            font-size: 0.875rem !important;
                            color: #64748b !important;
                        }
                    </style>
                    HTML),
            )
            ->renderHook(
                PanelsRenderHook::AUTH_LOGIN_FORM_AFTER,
                fn (): HtmlString => new HtmlString('
                    <div class="kalimarau-login-footer text-center">
                        <a href="/" class="kalimarau-login-back font-medium text-gray-500 hover:text-primary-600 transition-colors inline-flex items-center gap-1.5 fi-btn-link">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            Kembali ke Beranda Web
                        </a>
                        <div class="kalimarau-login-credit border-t border-gray-100/80 font-normal">
                            &copy; 2026 Bandara Kalimarau - UPT Kementerian Perhubungan RI
                        </div>
                    </div>
                ')
            );
    }
}
