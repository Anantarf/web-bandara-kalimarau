# Frontend QA Uplift Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Raise every category of the frontend QA scorecard (visual consistency, typography, responsive design, component reuse, performance, accessibility, code quality) from its current score to 8/10 or higher, using targeted, verified fixes rather than a rewrite.

**Architecture:** No new dependencies, no build-tool changes. Work is a series of small, independently-shippable Blade/CSS/JS edits: (1) extract the most-duplicated markup into one shared Blade component, (2) fix the two concrete performance regressions (font loading, inline `<style>`), (3) introduce three small heading/spacing utility classes in `app.css` and apply them where headings currently diverge, (4) fix the identified contrast and responsive edge cases, (5) move the one large piece of untestable inline JS (weather widget) into `resources/js/`, (6) replace one hard-coded hex palette with existing theme tokens.

**Tech Stack:** Laravel 11 Blade components, Tailwind CSS 4 (`@theme` tokens in `resources/css/app.css`), Alpine.js 3, Vite.

## Global Constraints

- No new npm/composer dependencies.
- Do not change route names, controller logic, or database schema — this plan is view/asset layer only.
- Every existing page must render identically in content and functionality; only markup structure, class names, and JS location may change.
- This codebase has no Dusk/JS test suite for views, and PHPUnit here covers the admin panel, not public Blade rendering. "Test" steps in this plan are therefore: `php artisan view:clear` (forces Blade recompilation, surfaces syntax errors), `php -l <file>` where applicable, `vendor/bin/pint --dirty` for PHP-in-Blade style, and a `grep` verification that old patterns are fully replaced. Each task also ends with a one-line manual visual-check note — run `npm run dev` and open the listed route(s) in a browser before treating the task as done.
- Follow existing Blade conventions already in the codebase: `@props`, `x-data`/`x-show`/`x-transition` for interactivity, Tailwind utility classes (no new CSS methodology).

---

### Task 1: Extract shared `<x-breadcrumb>` component (fixes: component reuse, contributes to: visual consistency, accessibility)

**Files:**
- Create: `resources/views/components/breadcrumb.blade.php`
- Modify: `resources/views/pages/show.blade.php:14-24`
- Modify: `resources/views/posts/show.blade.php:15-29`
- Modify: `resources/views/posts/index.blade.php:9-19`
- Modify: `resources/views/flights/index.blade.php:9-17`
- Modify: `resources/views/contact/index.blade.php:9-19`
- Modify: `resources/views/pages/ppid.blade.php:22-42`

**Interfaces:**
- Produces: `<x-breadcrumb :items="[['label' => string, 'url' => string|null], ...]" />` — the last array item is treated as the current page (rendered as `<span aria-current="page">`, no trailing chevron); any earlier item with a non-null `url` renders as a link, any earlier item with a `null` url renders as plain text (used by the PPID index case).

This is a pure Blade markup task — no PHP logic to unit test. Verification is `php artisan view:clear` + `php -l` + grep, per the Global Constraints note.

- [ ] **Step 1: Create the component**

```blade
{{-- resources/views/components/breadcrumb.blade.php --}}
@props(['items'])

<nav class="text-sm" aria-label="Breadcrumb">
    <ol class="list-none p-0 inline-flex flex-wrap">
        @foreach($items as $item)
            <li class="flex items-center">
                @if($loop->last)
                    <span class="text-gray-800 font-medium {{ $item['class'] ?? '' }}" aria-current="page">{{ $item['label'] }}</span>
                @elseif(!empty($item['url']))
                    <a href="{{ $item['url'] }}" class="text-gray-600 hover:text-navy transition-colors">{{ $item['label'] }}</a>
                @else
                    <span class="text-gray-800 font-medium">{{ $item['label'] }}</span>
                @endif
                @unless($loop->last)
                    <svg class="fill-current w-3 h-3 mx-2 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"/></svg>
                @endunless
            </li>
        @endforeach
    </ol>
</nav>
```

Note the link color changes from the old `text-gray-500` to `text-gray-600` — this is a deliberate contrast fix (WCAG AA for small text on the `bg-gray-50` breadcrumb strip used by every caller), applied once here instead of six times.

- [ ] **Step 2: Adopt it in `pages/show.blade.php`**

Replace lines 14-24:

```blade
            <nav class="text-sm" aria-label="Breadcrumb">
                <ol class="list-none p-0 inline-flex flex-wrap">
                    <li class="flex items-center">
                        <a href="{{ route('home') }}" class="text-gray-500 hover:text-blue-600">Beranda</a>
                        <svg class="fill-current w-3 h-3 mx-2 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"/></svg>
                    </li>
                    <li>
                        <span class="text-gray-800 font-medium truncate max-w-[200px] md:max-w-md inline-block" aria-current="page">{{ $page->title }}</span>
                    </li>
                </ol>
            </nav>
```

with:

```blade
            <x-breadcrumb :items="[
                ['label' => 'Beranda', 'url' => route('home')],
                ['label' => $page->title, 'class' => 'truncate max-w-[200px] md:max-w-md inline-block'],
            ]" />
```

- [ ] **Step 3: Adopt it in `posts/show.blade.php`**

Replace lines 15-29 (breadcrumb `<nav>...</nav>`) with:

```blade
            <x-breadcrumb :items="[
                ['label' => 'Beranda', 'url' => route('home')],
                ['label' => 'Berita', 'url' => route('posts.index')],
                ['label' => $post->title, 'class' => 'truncate max-w-[200px] md:max-w-md inline-block'],
            ]" />
```

- [ ] **Step 4: Adopt it in `posts/index.blade.php`**

Replace lines 9-19 with:

```blade
            <x-breadcrumb :items="[
                ['label' => 'Beranda', 'url' => route('home')],
                ['label' => 'Berita'],
            ]" />
```

- [ ] **Step 5: Adopt it in `flights/index.blade.php`**

Replace lines 9-17 with:

```blade
            <x-breadcrumb :items="[
                ['label' => 'Beranda', 'url' => route('home')],
                ['label' => 'Jadwal Penerbangan'],
            ]" />
```

- [ ] **Step 6: Adopt it in `contact/index.blade.php`**

Replace lines 9-19 with:

```blade
            <x-breadcrumb :items="[
                ['label' => 'Beranda', 'url' => route('home')],
                ['label' => 'Pengaduan & Kontak'],
            ]" />
```

- [ ] **Step 7: Adopt it in `pages/ppid.blade.php`**

Replace lines 22-42 (the whole `<nav>...</nav>` breadcrumb block) with:

```blade
            @php
                $breadcrumbItems = [['label' => 'Beranda', 'url' => route('home')]];
                $breadcrumbItems[] = $currentSub
                    ? ['label' => 'PPID', 'url' => route('ppid.show')]
                    : ['label' => 'PPID'];
                if ($currentSub) {
                    $breadcrumbItems[] = ['label' => $page->title];
                }
            @endphp
            <x-breadcrumb :items="$breadcrumbItems" />
```

- [ ] **Step 8: Verify**

```bash
php artisan view:clear
php -l resources/views/components/breadcrumb.blade.php
```

Expected: "Compiled views cleared successfully." and "No syntax errors detected."

```bash
grep -rn "fill-current w-3 h-3 mx-2 text-gray-400" resources/views --include="*.blade.php" | grep -v components/breadcrumb.blade.php
```

Expected: no output — the chevron SVG now exists only inside the new component.

Manual check: open `/`, `/berita`, `/berita/{any-slug}`, `/jadwal-penerbangan`, `/kontak`, `/ppid` and confirm the breadcrumb trail still shows the correct labels/links on each.

- [ ] **Step 9: Commit**

```bash
git add resources/views/components/breadcrumb.blade.php resources/views/pages/show.blade.php resources/views/posts/show.blade.php resources/views/posts/index.blade.php resources/views/flights/index.blade.php resources/views/contact/index.blade.php resources/views/pages/ppid.blade.php
git commit -m "refactor: extract shared breadcrumb component"
```

---

### Task 2: Fix render-blocking font loading (fixes: performance)

**Files:**
- Modify: `resources/css/app.css:1`
- Modify: `resources/views/components/layouts/public.blade.php:33-37`

**Interfaces:**
- No new interfaces — this only changes how the `Plus Jakarta Sans` font is fetched.

- [ ] **Step 1: Remove the blocking `@import` from `app.css`**

In `resources/css/app.css`, delete line 1:

```css
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
```

so the file starts directly with:

```css
@import "tailwindcss";
@plugin "@tailwindcss/typography";
```

- [ ] **Step 2: Load the font via preconnected `<link>` tags in the layout head**

In `resources/views/components/layouts/public.blade.php`, replace:

```blade
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo-blu.png') }}">

    <!-- Scripts and Styles (fonts + Alpine.js bundled via app.css/app.js) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
```

with:

```blade
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo-blu.png') }}">

    <!-- Fonts: preconnect + non-blocking stylesheet -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap">

    <!-- Scripts and Styles (Alpine.js bundled via app.css/app.js) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
```

This lets the browser open the font connection in parallel with downloading `app.css` instead of discovering the font host only after `app.css` has fully loaded and been parsed.

- [ ] **Step 3: Verify**

```bash
php artisan view:clear
grep -n "fonts.googleapis" resources/css/app.css resources/views/components/layouts/public.blade.php
```

Expected: no match in `app.css`, one `<link rel="stylesheet">` match in `public.blade.php`.

Manual check: `npm run build` (or `npm run dev`), open any page, confirm the network waterfall shows the font stylesheet request starting immediately alongside `app.css`, not after it, and that headings still render in Plus Jakarta Sans (not a fallback serif/sans).

- [ ] **Step 4: Commit**

```bash
git add resources/css/app.css resources/views/components/layouts/public.blade.php
git commit -m "perf: load Google Font via preconnected link instead of blocking @import"
```

---

### Task 3: Move inline `<style>` out of `home.blade.php` (fixes: performance, code quality)

**Files:**
- Modify: `resources/views/home.blade.php:80-84`
- Modify: `resources/css/app.css`

**Interfaces:**
- Produces: `.scrollbar-hide` utility class in `app.css`, replacing the ad hoc inline `<style>` block and the duplicate `style="scrollbar-width: none; -ms-overflow-style: none;"` attribute already present on the same element.

- [ ] **Step 1: Add the utility class to `app.css`**

Append after the `:focus-visible` block (after line 39):

```css
.scrollbar-hide {
  scrollbar-width: none;
  -ms-overflow-style: none;
}

.scrollbar-hide::-webkit-scrollbar {
  display: none;
}
```

- [ ] **Step 2: Update `home.blade.php`**

Replace (lines 80-84):

```blade
            <div x-show="show" x-transition:enter="transition-all ease-out duration-1000 delay-[900ms]" x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;" class="flex flex-nowrap justify-start sm:justify-center items-center gap-2.5 sm:gap-3 mb-8 sm:mb-12 w-[90%] max-w-4xl overflow-x-auto pb-2" style="scrollbar-width: none; -ms-overflow-style: none;">
                <style>
                    /* Hide scrollbar for Chrome, Safari and Opera */
                    .overflow-x-auto::-webkit-scrollbar { display: none; }
                </style>
```

with:

```blade
            <div x-show="show" x-transition:enter="transition-all ease-out duration-1000 delay-[900ms]" x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;" class="flex flex-nowrap justify-start sm:justify-center items-center gap-2.5 sm:gap-3 mb-8 sm:mb-12 w-[90%] max-w-4xl overflow-x-auto scrollbar-hide pb-2">
```

(Note this also fixes a real bug — the element had two `style=` attributes on one tag, and only the second wins in HTML parsing, so `display: none` from `x-show` and the scrollbar hiding were fighting over the same attribute. `.scrollbar-hide` as a class removes that collision entirely.)

- [ ] **Step 3: Verify**

```bash
php artisan view:clear
grep -n "<style>" resources/views/home.blade.php
```

Expected: no match.

Manual check: open `/`, scroll the social-media pill row horizontally on a narrow viewport (DevTools mobile emulation) — the scrollbar should stay hidden, same as before.

- [ ] **Step 4: Commit**

```bash
git add resources/css/app.css resources/views/home.blade.php
git commit -m "fix: replace inline style block with scrollbar-hide utility class"
```

---

### Task 4: Introduce heading-scale utility classes and apply where headings diverge (fixes: visual consistency, typography)

**Files:**
- Modify: `resources/css/app.css`
- Modify: `resources/views/contact/index.blade.php:49,87`
- Modify: `resources/views/pages/ppid.blade.php:157`
- Modify: `resources/views/posts/show.blade.php:91`
- Modify: `resources/views/errors/404.blade.php:9`

**Interfaces:**
- Produces: `.card-title` (panel-level heading, text-xl) and `.subsection-title` (in-page section heading, text-2xl) utility classes, both using the `navy-dark` token instead of raw gray.

- [ ] **Step 1: Add the utility classes to `app.css`**

Append after the `.scrollbar-hide` block added in Task 3:

```css
.card-title {
  @apply text-xl font-bold text-navy-dark;
}

.subsection-title {
  @apply text-2xl font-bold text-navy-dark;
}
```

- [ ] **Step 2: Apply `.card-title` in `contact/index.blade.php`**

Line 49, replace:

```blade
                        <h2 class="text-xl font-bold text-gray-900 mb-6">Informasi Kontak</h2>
```

with:

```blade
                        <h2 class="card-title mb-6">Informasi Kontak</h2>
```

Line 87, replace:

```blade
                        <h2 class="text-xl font-bold text-gray-900 mb-6">Kirim Pesan atau Pengaduan</h2>
```

with:

```blade
                        <h2 class="card-title mb-6">Kirim Pesan atau Pengaduan</h2>
```

- [ ] **Step 3: Apply `.subsection-title` in `pages/ppid.blade.php`**

Line 157, replace:

```blade
                            <h2 class="text-2xl font-bold text-gray-900 mb-6">{{ $page->title }}</h2>
```

with:

```blade
                            <h2 class="subsection-title mb-6">{{ $page->title }}</h2>
```

- [ ] **Step 4: Apply `.subsection-title` in `posts/show.blade.php`**

Line 91, replace:

```blade
            <h2 class="text-2xl font-bold text-gray-900 mb-8">Berita Terkait</h2>
```

with:

```blade
            <h2 class="subsection-title mb-8">Berita Terkait</h2>
```

- [ ] **Step 5: Apply `.subsection-title` in `errors/404.blade.php`**

Line 9, replace:

```blade
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Halaman Tidak Ditemukan</h2>
```

with:

```blade
            <h2 class="subsection-title text-3xl mb-4">Halaman Tidak Ditemukan</h2>
```

(Size stays `text-3xl` here since the 404 heading sits directly under the giant "404" numeral and needs the larger weight visually — only the color/weight/family are being unified, via the `subsection-title` base plus a `text-3xl` override.)

- [ ] **Step 6: Verify**

```bash
php artisan view:clear
grep -n "text-gray-900" resources/views/contact/index.blade.php resources/views/pages/ppid.blade.php resources/views/posts/show.blade.php resources/views/errors/404.blade.php
```

Expected: only the small `<h3 class="font-semibold text-gray-900">` contact-info labels remain (lines 56, 66, 77 of `contact/index.blade.php`) — those are intentionally left as-is, they're field labels, not page/section headings.

Manual check: open `/kontak`, `/ppid`, any `/berita/{slug}`, and a broken URL (404 page) — headings should now read in navy-dark instead of near-black gray, matching the rest of the site's heading color.

- [ ] **Step 7: Commit**

```bash
git add resources/css/app.css resources/views/contact/index.blade.php resources/views/pages/ppid.blade.php resources/views/posts/show.blade.php resources/views/errors/404.blade.php
git commit -m "style: unify card/section heading scale and color via utility classes"
```

---

### Task 5: Fix breadcrumb-strip and interactive-text contrast (fixes: accessibility)

**Files:**
- Modify: `resources/views/faq.blade.php:12,20`

**Interfaces:** none — pure class-name edits.

Task 1 already fixed the six `<x-breadcrumb>` callers' link color (`text-gray-500` → `text-gray-600`). `faq.blade.php` builds its breadcrumb by hand (different markup shape — icon-prefixed links, not migrated in Task 1 to keep that task's diff mechanical) and has the same contrast issue plus a `text-gray-500` current-step label.

- [ ] **Step 1: Fix the "Beranda" link color**

Line 12, replace:

```blade
                        <a href="{{ route('home') }}" class="inline-flex items-center text-gray-500 hover:text-navy transition-colors">
```

with:

```blade
                        <a href="{{ route('home') }}" class="inline-flex items-center text-gray-600 hover:text-navy transition-colors">
```

- [ ] **Step 2: Fix the "Informasi" middle-crumb label color**

Line 20, replace:

```blade
                            <span class="ml-1 md:ml-2 text-gray-500">Informasi</span>
```

with:

```blade
                            <span class="ml-1 md:ml-2 text-gray-600">Informasi</span>
```

- [ ] **Step 3: Verify**

```bash
php artisan view:clear
grep -n "text-gray-500" resources/views/faq.blade.php
```

Expected: no match.

Manual check: open `/faq`, confirm the breadcrumb text is legibly darker against the `bg-gray-50` strip, same visual weight as the other pages' breadcrumbs from Task 1.

- [ ] **Step 4: Commit**

```bash
git add resources/views/faq.blade.php
git commit -m "fix: darken breadcrumb text on FAQ page for contrast"
```

---

### Task 6: Fix responsive edge cases — hero viewport height and floating-contact panel width (fixes: responsive design)

**Files:**
- Modify: `resources/views/home.blade.php:11`
- Modify: `resources/views/components/public/floating-contact.blade.php:19`

**Interfaces:** none — pure class-name edits.

- [ ] **Step 1: Add a static-viewport fallback to the hero height**

Line 11 of `home.blade.php`, replace:

```blade
             class="relative w-full overflow-hidden bg-navy-dark h-[100dvh] min-h-[600px] flex flex-col justify-center">
```

with:

```blade
             class="relative w-full overflow-hidden bg-navy-dark h-screen h-[100dvh] min-h-[600px] flex flex-col justify-center">
```

`h-screen` (`100vh`) is declared first as a fallback for browsers/engines that don't support `dvh`; the later `h-[100dvh]` still wins wherever it's supported (CSS cascade — same specificity, later declaration wins), so this only helps browsers that would otherwise ignore the `dvh` value entirely.

- [ ] **Step 2: Cap the floating-contact panel width so it never overflows narrow viewports**

Line 19 of `floating-contact.blade.php`, replace:

```blade
         class="bg-white rounded-3xl shadow-2xl border border-border-soft w-[340px] overflow-hidden" 
```

with:

```blade
         class="bg-white rounded-3xl shadow-2xl border border-border-soft w-[calc(100vw-3rem)] max-w-[340px] overflow-hidden" 
```

The panel sits at `bottom-6 right-6` (1.5rem inset on each side = 3rem total), so `calc(100vw - 3rem)` guarantees it never touches the viewport edges on phones narrower than 340+48px, while `max-w-[340px]` keeps the original size on everything larger.

- [ ] **Step 3: Verify**

```bash
php artisan view:clear
```

Manual check: open `/` in DevTools at 320px width (iPhone SE) — hero should fill the viewport without an odd gap or overflow from address-bar collapse, and clicking the floating contact button should open a popup that stays fully on-screen with visible margin on both sides.

- [ ] **Step 4: Commit**

```bash
git add resources/views/home.blade.php resources/views/components/public/floating-contact.blade.php
git commit -m "fix: responsive hero height fallback and floating-contact panel width on narrow screens"
```

---

### Task 7: Extract the weather-widget script from `home.blade.php` into `resources/js/` (fixes: code quality, contributes to: performance)

**Files:**
- Create: `resources/js/weather.js`
- Modify: `resources/js/app.js`
- Modify: `resources/views/home.blade.php:29-63`

**Interfaces:**
- Produces: an Alpine component registered as `Alpine.data('weatherWidget', ...)`, exposing `temp`, `desc`, `icon` (reactive state) the same way the inline version did.
- Consumes: nothing new — same public Open-Meteo endpoint, same fallback values.

- [ ] **Step 1: Create `resources/js/weather.js`**

```javascript
export default function weatherWidget() {
    return {
        temp: '...',
        desc: 'Memuat cuaca...',
        icon: 'cloud',
        async fetchWeather() {
            try {
                const res = await fetch('https://api.open-meteo.com/v1/forecast?latitude=2.152&longitude=117.491&current_weather=true');
                const data = await res.json();
                const current = data.current_weather;
                this.temp = Math.round(current.temperature) + '°C';

                const code = current.weathercode;
                if (code <= 1) { this.desc = 'Cerah'; this.icon = 'sun'; }
                else if (code <= 3) { this.desc = 'Berawan'; this.icon = 'cloud'; }
                else if (code <= 48) { this.desc = 'Kabut'; this.icon = 'cloud'; }
                else if (code <= 57) { this.desc = 'Gerimis'; this.icon = 'rain'; }
                else if (code <= 82) { this.desc = 'Hujan'; this.icon = 'rain'; }
                else { this.desc = 'Badai Petir'; this.icon = 'lightning'; }
            } catch (e) {
                this.temp = '28°C';
                this.desc = 'Cerah';
                this.icon = 'sun';
            }
        },
    };
}
```

- [ ] **Step 2: Register it in `resources/js/app.js`**

Read the current file first — it currently registers Alpine plugins and calls `Alpine.start()`. Add the import and registration before `Alpine.start()`:

```javascript
import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse';
import weatherWidget from './weather';

window.Alpine = Alpine;
Alpine.plugin(collapse);
Alpine.data('weatherWidget', weatherWidget);
Alpine.start();
```

- [ ] **Step 3: Replace the inline widget in `home.blade.php`**

Replace lines 29-63:

```blade
                <div x-data="{ 
                        temp: '...', 
                        desc: 'Memuat cuaca...',
                        icon: 'cloud',
                        async fetchWeather() {
                            try {
                                const res = await fetch('https://api.open-meteo.com/v1/forecast?latitude=2.152&longitude=117.491&current_weather=true');
                                const data = await res.json();
                                const current = data.current_weather;
                                this.temp = Math.round(current.temperature) + '°C';
                                
                                const code = current.weathercode;
                                if (code <= 1) { this.desc = 'Cerah'; this.icon = 'sun'; }
                                else if (code <= 3) { this.desc = 'Berawan'; this.icon = 'cloud'; }
                                else if (code <= 48) { this.desc = 'Kabut'; this.icon = 'cloud'; }
                                else if (code <= 57) { this.desc = 'Gerimis'; this.icon = 'rain'; }
                                else if (code <= 82) { this.desc = 'Hujan'; this.icon = 'rain'; }
                                else { this.desc = 'Badai Petir'; this.icon = 'lightning'; }
                            } catch (e) {
                                this.temp = '28°C';
                                this.desc = 'Cerah';
                                this.icon = 'sun';
                            }
                        }
                    }" 
                    x-init="fetchWeather()"
                    x-show="show" x-transition:enter="transition-all ease-out duration-1000 delay-500" x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;" class="inline-flex items-center gap-3 bg-white/10 backdrop-blur-md border border-white/20 rounded-full px-6 py-2.5 shadow-lg">
```

with:

```blade
                <div x-data="weatherWidget" x-init="fetchWeather()"
                    x-show="show" x-transition:enter="transition-all ease-out duration-1000 delay-500" x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;" class="inline-flex items-center gap-3 bg-white/10 backdrop-blur-md border border-white/20 rounded-full px-6 py-2.5 shadow-lg">
```

Leave the four `<svg x-show="icon === '...'">` lines and the closing `</div>` right after them untouched — they still read `icon` and `temp`/`desc` from the same (now externally-defined) Alpine scope.

- [ ] **Step 4: Verify**

```bash
npm run build
```

Expected: build succeeds with no errors referencing `weather.js` or `app.js`.

```bash
grep -n "fetchWeather" resources/views/home.blade.php
```

Expected: one match (`x-init="fetchWeather()"`), no inline function body.

Manual check: open `/`, confirm the weather pill still shows a temperature and description a few seconds after page load (or the `28°C / Cerah` fallback if the API call fails), same as before.

- [ ] **Step 5: Commit**

```bash
git add resources/js/weather.js resources/js/app.js resources/views/home.blade.php
git commit -m "refactor: extract weather widget from inline Alpine markup into resources/js"
```

---

### Task 8: Replace hard-coded hex palette with theme tokens (fixes: code quality)

**Files:**
- Modify: `resources/css/app.css`
- Modify: `resources/views/flights/index.blade.php:34`

**Interfaces:**
- Produces: six new `--color-airline-1` … `--color-airline-6` tokens in the `@theme` block, values unchanged from the existing hard-coded array, so no visual difference — only the source of truth moves.

- [ ] **Step 1: Add the tokens to `app.css`**

In the `@theme` block, after the `--color-blue-900` line, add:

```css
  --color-airline-1: #1E6FB5;
  --color-airline-2: #C8860A;
  --color-airline-3: #1A7A4A;
  --color-airline-4: #7A3A1A;
  --color-airline-5: #5A1A7A;
  --color-airline-6: #0C2D6B;
```

- [ ] **Step 2: Update `flights/index.blade.php`**

Line 34, replace:

```blade
                $palette = ['#1E6FB5', '#C8860A', '#1A7A4A', '#7A3A1A', '#5A1A7A', '#0C2D6B'];
```

with:

```blade
                $palette = ['var(--color-airline-1)', 'var(--color-airline-2)', 'var(--color-airline-3)', 'var(--color-airline-4)', 'var(--color-airline-5)', 'var(--color-airline-6)'];
```

This array is only used where it's already consumed further down as an inline CSS custom property/color value (`$airlineColor($name)` selects one of these six strings), so passing a `var(--...)` string instead of a literal hex works identically at render time.

- [ ] **Step 3: Verify**

```bash
php artisan view:clear
grep -n "airline-1\|1E6FB5" resources/css/app.css resources/views/flights/index.blade.php
```

Expected: token defined once in `app.css`, referenced (not redefined) in `flights/index.blade.php`.

Manual check: open `/jadwal-penerbangan`, confirm airline initials badges (for airlines without a logo) still render in the same six colors as before.

- [ ] **Step 4: Commit**

```bash
git add resources/css/app.css resources/views/flights/index.blade.php
git commit -m "refactor: move airline badge palette from hard-coded hex to theme tokens"
```

---

### Task 9: Full-site verification pass

**Files:** none modified — this task only runs checks.

- [ ] **Step 1: Lint and rebuild**

```bash
vendor/bin/pint --dirty
npm run build
php artisan view:clear
```

Expected: Pint reports no unfixed issues, `npm run build` completes without errors, views clear successfully.

- [ ] **Step 2: Syntax-check every touched Blade file**

```bash
for f in resources/views/components/breadcrumb.blade.php resources/views/pages/show.blade.php resources/views/posts/show.blade.php resources/views/posts/index.blade.php resources/views/flights/index.blade.php resources/views/contact/index.blade.php resources/views/pages/ppid.blade.php resources/views/home.blade.php resources/views/faq.blade.php resources/views/errors/404.blade.php resources/views/components/public/floating-contact.blade.php resources/views/components/layouts/public.blade.php; do php -l "$f"; done
```

Expected: "No syntax errors detected" for every file.

- [ ] **Step 3: Manual click-through**

Open each of these routes in a browser (light and dark are not in scope — this site has no dark mode) and confirm no visual regression against the pre-plan state: `/`, `/berita`, `/berita/{a-post-slug}`, `/jadwal-penerbangan`, `/kontak`, `/ppid`, `/ppid/{a-sub-slug}`, `/faq`, `/pencarian?q=test`, a deliberately broken URL for the 404 page. Confirm at 375px, 768px, and 1280px widths.

- [ ] **Step 4: Commit (only if Step 1 produced changes)**

```bash
git add -A
git commit -m "chore: pint fixes from frontend QA uplift pass"
```

---

## Expected outcome per scorecard category

| Category | Before | Task(s) that address it |
|---|---|---|
| Visual consistency | 6/10 | 1 (breadcrumb link color unified), 4 (heading scale/color unified) |
| Typography | 7/10 | 4 |
| Responsive design | 7/10 | 6 |
| Component reuse | 3/10 | 1 |
| Performance | 4/10 | 2, 3 |
| Accessibility | 6/10 | 1, 5 |
| Code quality | 4/10 | 3, 7, 8 |

Re-run the same QA judge pass after all 9 tasks land to confirm each category actually clears 8/10 — this plan is scoped from the concrete findings of that pass, but the re-score is the real acceptance test, not this table.
