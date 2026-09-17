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

                        @keyframes floatOrb1 {
                            0% { transform: translate(0px, 0px) scale(1); }
                            33% { transform: translate(100px, -60px) scale(1.15); }
                            66% { transform: translate(-60px, 50px) scale(0.9); }
                            100% { transform: translate(0px, 0px) scale(1); }
                        }

                        @keyframes floatOrb2 {
                            0% { transform: translate(0px, 0px) scale(1); }
                            33% { transform: translate(-90px, 80px) scale(1.1); }
                            66% { transform: translate(70px, -40px) scale(0.85); }
                            100% { transform: translate(0px, 0px) scale(1); }
                        }

                        /* Compact 1-Page Non-Scrollable Login Layout with Ambient Background */
                        html,
                        body.fi-body-has-no-sidebar {
                            height: 100% !important;
                            max-height: 100vh !important;
                            overflow: hidden !important;
                            margin: 0 !important;
                            padding: 0 !important;
                            background: #051330 url('/images/hero/hero1.jpg') center/cover no-repeat fixed !important;
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
                            background: linear-gradient(135deg, rgba(5, 19, 48, 0.58) 0%, rgba(9, 31, 74, 0.48) 100%) !important;
                            backdrop-filter: blur(2.5px) brightness(0.92) !important;
                            -webkit-backdrop-filter: blur(2.5px) brightness(0.92) !important;
                        }

                        /* Floating Ambient Glow Orbs (Subtle background accents) */
                        .fi-simple-layout::before {
                            content: '';
                            position: absolute;
                            top: -10%;
                            left: -10%;
                            width: 50vw;
                            height: 50vw;
                            max-width: 550px;
                            max-height: 550px;
                            background: radial-gradient(circle, rgba(30, 111, 181, 0.45) 0%, rgba(30, 111, 181, 0) 70%) !important;
                            filter: blur(50px) !important;
                            animation: floatOrb1 12s ease-in-out infinite !important;
                            z-index: 0;
                            pointer-events: none;
                            opacity: 0.65;
                        }
                        .fi-simple-layout::after {
                            content: '';
                            position: absolute;
                            bottom: -10%;
                            right: -10%;
                            width: 50vw;
                            height: 50vw;
                            max-width: 550px;
                            max-height: 550px;
                            background: radial-gradient(circle, rgba(200, 134, 10, 0.4) 0%, rgba(200, 134, 10, 0) 70%) !important;
                            filter: blur(55px) !important;
                            animation: floatOrb2 15s ease-in-out infinite !important;
                            z-index: 0;
                            pointer-events: none;
                            opacity: 0.55;
                        }

                        .fi-simple-main {
                            position: relative;
                            z-index: 10;
                            background-color: rgba(255, 255, 255, 0.96) !important;
                            backdrop-filter: blur(12px) !important;
                            -webkit-backdrop-filter: blur(12px) !important;
                            border-radius: 1rem !important;
                            box-shadow: 0 1.625rem 3.25rem -1rem rgba(5, 19, 48, 0.42), 0 0 0 1px rgba(255, 255, 255, 0.36) !important;
                            border: 1px solid rgba(255, 255, 255, 0.42) !important;
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

                        /* 4. Table Rows - Highlight */
                        .fi-ta-row {
                            transition: background-color 0.2s ease-in-out, box-shadow 0.2s ease-in-out !important;
                        }
                        .fi-ta-row:hover {
                            background-color: #f5f7fb !important;
                            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
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
                            z-index: 99999 !important;
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
                    <div class="text-center mt-2.5">
                        <a href="/" class="text-xs font-medium text-gray-500 hover:text-primary-600 transition-colors inline-flex items-center gap-1.5 fi-btn-link">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            Kembali ke Beranda Web
                        </a>
                        <div class="mt-2 pt-2 border-t border-gray-100/80 text-[10px] text-gray-400 font-normal tracking-tight">
                            &copy; 2026 Bandara Kalimarau - UPT Kementerian Perhubungan RI
                        </div>
                    </div>
                ')
            );
    }
}
