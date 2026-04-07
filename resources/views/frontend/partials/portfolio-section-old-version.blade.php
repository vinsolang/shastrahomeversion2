{{-- Portfolio Section --}}
@php
    $portfolio    = $portfolio    ?? [];
    $isStandalone = $isStandalone ?? false;
    $heading      = $portfolio['heading']  ?? [];
    $tabs         = $portfolio['tabs']     ?? [];
    $projects     = $portfolio['projects'] ?? [];

    $resolveMediaAsset = static function (mixed $asset, string $projectTitle, int $index): ?array {
        if (is_string($asset)) {
            $extension = strtolower(pathinfo($asset, PATHINFO_EXTENSION));
            $isVideo   = in_array($extension, ['mp4', 'webm', 'ogg'], true);
            return [
                'type'   => $isVideo ? 'video' : 'image',
                'src'    => asset($asset),
                'poster' => null,
                'mime'   => $isVideo ? 'video/' . $extension : null,
                'alt'    => sprintf('%s image %d', $projectTitle, $index),
            ];
        }
        if (! is_array($asset) || ! filled($asset['src'] ?? null)) {
            return null;
        }
        return [
            'type'   => $asset['type'] ?? 'image',
            'src'    => asset($asset['src']),
            'poster' => filled($asset['poster'] ?? null) ? asset($asset['poster']) : null,
            'mime'   => $asset['mime'] ?? null,
            'alt'    => $asset['alt'] ?? sprintf('%s image %d', $projectTitle, $index),
        ];
    };

    $interactiveProjects = collect($projects)
        ->map(function (array $project) use ($resolveMediaAsset): array {
            $gallery = collect($project['gallery'] ?? [])
                ->map(fn (mixed $asset, int $index): ?array => $resolveMediaAsset($asset, $project['title'], $index + 1))
                ->filter()
                ->values()
                ->all();
            return [
                ...$project,
                'cover_image' => data_get($gallery, '0.poster') ?? data_get($gallery, '0.src') ?? asset($project['cover_image']),
                'gallery'     => $gallery,
            ];
        })
        ->values()
        ->all();
@endphp

<style>
/* ─────────────────────────────────────────────────────────────
   CARD BASE — zero shadows everywhere
───────────────────────────────────────────────────────────── */
.project-card {
    cursor: pointer;
    outline: none;
    box-shadow: none !important;
    transition: transform 0.35s cubic-bezier(0.22, 1, 0.36, 1);
}
.project-card:focus-visible {
    outline: 2px solid rgba(255, 136, 0, 0.55);
    outline-offset: 2px;
}
.project-card--expanded {
    box-shadow: none !important;
}

/* No embedded-breakout needed — all pages pass isStandalone=true */

/* ─────────────────────────────────────────────────────────────
   COLLAPSED THUMBNAIL
───────────────────────────────────────────────────────────── */
.project-story-fallback { width: 100%; height: 100%; overflow: hidden; }
.project-story-fallback__media { width: 100%; height: 100%; }
.project-story-fallback__media img,
.project-story-fallback__media video {
    width: 100%; height: 100%; object-fit: cover;
    transition: transform 0.65s cubic-bezier(0.22, 1, 0.36, 1);
}
.project-card:hover .project-story-fallback__media img,
.project-card:hover .project-story-fallback__media video { transform: scale(1.03); }

/* ─────────────────────────────────────────────────────────────
   STORY VIEW — horizontal snap-scroll container
   Scroll order (left → right):
     [1] Lead image panel (100% wide, auto-scrolled to on open)
     [2] Details panel   (45% wide, swipe left to reveal)
     [3…] Secondary image panels (62% wide each)
───────────────────────────────────────────────────────────── */
.project-story-view {
    display: flex;
    overflow-x: auto;
    gap: 0;
    scroll-snap-type: x mandatory;
    -webkit-overflow-scrolling: touch;
    height: 520px;          /* single source of truth for all panel heights */
    scroll-behavior: smooth;
    width: 100%;
    padding: 0;
    scrollbar-width: none;
    -ms-overflow-style: none;
    opacity: 0;
    animation: storyFadeIn 0.5s cubic-bezier(0.22, 1, 0.36, 1) forwards;
}
.project-story-view::-webkit-scrollbar { display: none; }
@keyframes storyFadeIn {
    from { opacity: 0; transform: translateY(8px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* ─────────────────────────────────────────────────────────────
   PANEL 1 — LEAD IMAGE (full-width, first in scroll)
───────────────────────────────────────────────────────────── */
.project-story-panel--lead {
    flex: 0 0 calc(100% - 88px); /* peek: shows ~88px of the details panel on the right */
    height: 100%;
    scroll-snap-align: start;
    overflow: hidden;
    position: relative;
    opacity: 0;
    animation: leadIn 0.55s cubic-bezier(0.22, 1, 0.36, 1) 0.04s forwards;
}
@keyframes leadIn {
    from { opacity: 0; transform: scale(0.985) translateY(6px); }
    to   { opacity: 1; transform: scale(1) translateY(0); }
}
.project-story-panel--lead img,
.project-story-panel--lead video {
    width: 100%; height: 100%; object-fit: cover; display: block;
    transition: transform 0.8s cubic-bezier(0.22, 1, 0.36, 1);
}
.project-story-panel--lead:hover img,
.project-story-panel--lead:hover video { transform: scale(1.04); }

/* ─────────────────────────────────────────────────────────────
   PANEL 2 — DETAILS (text panel, second in scroll)
   User swipes left from the lead image to reveal this.
───────────────────────────────────────────────────────────── */
.project-story-panel--details {
    flex: 0 0 calc(48% - 44px); /* peek: shows start of secondary image panel on the right */
    min-width: 280px;
    height: 100%;
    scroll-snap-align: start;
    background: #faf7f2;
    display: flex;
    flex-direction: column;
    justify-content: center;
    padding: 2.75rem 2.5rem 2.75rem 2.25rem;
    overflow-y: auto;
    overflow-x: hidden;
    overscroll-behavior: contain;  /* stops scroll chaining into the horizontal parent */
    touch-action: pan-y;           /* tells browser: handle vertical finger drags here */
    box-sizing: border-box;
    opacity: 0;
    animation: detailsIn 0.5s cubic-bezier(0.22, 1, 0.36, 1) 0.18s forwards;
}
@keyframes detailsIn {
    from { opacity: 0; transform: translateX(20px); }
    to   { opacity: 1; transform: translateX(0); }
}

/* Swipe hint arrow inside details panel */
.project-story-panel--details .swipe-hint {
    display: flex;
    align-items: center;
    gap: 0.35rem;
    margin-bottom: 2rem;
    opacity: 0.35;
    font-size: 0.68rem;
    font-weight: 700;
    letter-spacing: 0.16em;
    text-transform: uppercase;
    color: #1f1f1f;
    user-select: none;
    animation: swipeHintPulse 2s ease-in-out 1.2s 2 alternate;
}
@keyframes swipeHintPulse {
    from { opacity: 0.35; transform: translateX(0); }
    to   { opacity: 0.65; transform: translateX(4px); }
}
.project-story-panel--details .swipe-hint svg {
    width: 14px; height: 14px;
    flex-shrink: 0;
}

/* ─────────────────────────────────────────────────────────────
   PANELS 3+ — SECONDARY image-only panels
───────────────────────────────────────────────────────────── */
.project-story-panel {
    flex: 0 0 68%; /* shows ~32% of the next secondary panel as a peek */
    height: 100%;
    scroll-snap-align: start;
    overflow: hidden;
    position: relative;
    opacity: 0;
    animation: panelIn 0.48s cubic-bezier(0.22, 1, 0.36, 1) forwards;
}
.project-story-panel:nth-child(3) { animation-delay: 0.20s; }
.project-story-panel:nth-child(4) { animation-delay: 0.26s; }
.project-story-panel:nth-child(5) { animation-delay: 0.32s; }
.project-story-panel:nth-child(6) { animation-delay: 0.38s; }
.project-story-panel:nth-child(7) { animation-delay: 0.44s; }
@keyframes panelIn {
    from { opacity: 0; transform: translateX(22px); }
    to   { opacity: 1; transform: translateX(0); }
}
.project-story-panel__media { height: 100%; width: 100%; overflow: hidden; }
.project-story-panel__media img,
.project-story-panel__media video {
    width: 100%; height: 100%; object-fit: cover; display: block;
    transition: transform 0.65s cubic-bezier(0.22, 1, 0.36, 1);
}
.project-story-panel:hover .project-story-panel__media img,
.project-story-panel:hover .project-story-panel__media video { transform: scale(1.03); }

/* ─────────────────────────────────────────────────────────────
   DETAILS COPY — typography & layout
───────────────────────────────────────────────────────────── */
.project-story-copy__label {
    font-size: 0.7rem;
    font-weight: 700;
    letter-spacing: 0.2em;
    text-transform: uppercase;
    color: #ff8800;
    margin: 0 0 0.6rem;
}
.project-story-copy__title {
    font-size: clamp(1.4rem, 2.2vw, 2rem);
    font-weight: 600;
    line-height: 1.15;
    color: #1f1f1f;
    margin: 0 0 1.6rem;
    padding-bottom: 1.4rem;
    border-bottom: 1px solid rgba(0, 0, 0, 0.08);
}
.project-story-copy__fields {
    display: flex;
    flex-direction: column;
    gap: 1.35rem;
}
.project-story-copy__field {
    display: flex;
    flex-direction: column;
    gap: 0.28rem;
}
.project-story-copy__field-label {
    font-size: 0.67rem;
    font-weight: 700;
    letter-spacing: 0.16em;
    text-transform: uppercase;
    color: #b0b0b0;
}
.project-story-copy__field-value {
    font-size: 0.96rem;
    line-height: 1.62;
    color: #2e2e2e;
}

/* ─────────────────────────────────────────────────────────────
   META COLUMN (visible only when card is collapsed)
───────────────────────────────────────────────────────────── */
.project-row__meta--hidden { display: none !important; }
.project-row__preview { width: 100%; overflow: hidden; }
.project-row { transition: border-radius 0.4s cubic-bezier(0.22, 1, 0.36, 1); }

/* ─────────────────────────────────────────────────────────────
   RESPONSIVE — stack vertically on mobile
───────────────────────────────────────────────────────────── */
@media (max-width: 767px) {
    .project-story-view { height: 320px; }

    .project-story-panel--lead {
        flex: 0 0 calc(100% - 48px); /* ~48px peek of details on mobile */
    }
    .project-story-panel--details {
        flex: 0 0 calc(88% - 36px); /* peek of secondary image on mobile */
        min-width: unset;
        padding: 1.5rem 1.25rem 2rem;
        justify-content: flex-start;
    }
    .project-story-panel--details .swipe-hint { margin-bottom: 1.25rem; }

    .project-story-panel { flex: 0 0 80%; }

    .project-story-copy__title {
        font-size: 1.2rem;
        margin-bottom: 1.1rem;
        padding-bottom: 0.9rem;
    }
}
</style>

{{-- ── Portfolio ── --}}
<section
    x-data="projectsPortfolio(@js([
        'tabs'         => $tabs,
        'projects'     => $interactiveProjects,
        'isStandalone' => $isStandalone,
    ]))"
    @class([
        'portfolio-section',
        'portfolio-section--standalone' => $isStandalone,
        'portfolio-section--embedded'   => ! $isStandalone,
    ])
>
    <div class="mx-auto max-w-[1904px]">
        <div class="mx-auto max-w-[92rem] px-4 sm:px-6 lg:px-8">

            {{-- ── Header ── --}}
            @if ($isStandalone)
                <div class="projects-topbar" data-aos="fade-up">
                    <div class="projects-topbar__heading" aria-hidden="true">
                        <span>{{ $heading['eyebrow'] ?? '' }}</span>
                        <span>{{ $heading['title'] ?? 'OUR PORTFOLIOS' }}</span>
                    </div>
                    <div class="projects-topbar__tabs">
                        @foreach ($tabs as $tab)
                            <button
                                type="button"
                                class="project-filter-tab"
                                :class="{ 'project-filter-tab--active': activeCategory === '{{ $tab }}' }"
                                :data-active="activeCategory === '{{ $tab }}' ? 'true' : 'false'"
                                :aria-pressed="activeCategory === '{{ $tab }}' ? 'true' : 'false'"
                                @click="setCategory('{{ $tab }}')"
                            >{{ $tab }}</button>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="projects-topbar-embedded" data-aos="fade-up">
                    <div class="projects-topbar-embedded__heading" aria-hidden="true">
                        <span>{{ $heading['eyebrow'] ?? '' }}</span>
                        <span>{{ $heading['title'] ?? 'OUR PORTFOLIOS' }}</span>
                    </div>
                    <div class="projects-topbar-embedded__tabs">
                        @foreach ($tabs as $tab)
                            <button
                                type="button"
                                class="project-filter-tab"
                                :class="{ 'project-filter-tab--active': activeCategory === '{{ $tab }}' }"
                                :data-active="activeCategory === '{{ $tab }}' ? 'true' : 'false'"
                                :aria-pressed="activeCategory === '{{ $tab }}' ? 'true' : 'false'"
                                @click="setCategory('{{ $tab }}')"
                            >{{ $tab }}</button>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- ── Project list ── --}}
            <div
                class="project-list space-y-5 lg:space-y-6"
                :class="{
                    'project-list--compact':      visibleProjectCount() <= 2,
                    'project-list--single':       visibleProjectCount() <= 1,
                    'project-list--has-expanded': expandedProjectId !== null
                }"
            >
                <template x-if="visibleProjectCount() === 0">
                    <div class="rounded-[1.75rem] border border-black/8 bg-[#faf7f2] px-6 py-10 text-center text-[0.96rem] text-[#5f5f5f]">
                        No projects are available in this category yet.
                    </div>
                </template>

                @foreach ($interactiveProjects as $project)
                    @php
                        $leadMedia      = $project['gallery'][0] ?? null;
                        $secondaryMedia = array_slice($project['gallery'], 1);
                    @endphp

                    <article
                        data-project-id="{{ $project['id'] }}"
                        x-show="isProjectVisible('{{ $project['id'] }}')"
                        x-transition:enter="transition duration-500 ease-[cubic-bezier(0.22,1,0.36,1)]"
                        x-transition:enter-start="opacity-0 translate-y-8 scale-[0.982]"
                        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                        x-transition:leave="transition duration-250 ease-[cubic-bezier(0.4,0,1,1)]"
                        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                        x-transition:leave-end="opacity-0 -translate-y-2 scale-[0.99]"
                        class="project-card"
                        :class="{ 'project-card--expanded': isExpanded('{{ $project['id'] }}') }"
                        data-aos="fade-up"
                        data-aos-duration="760"
                        data-aos-delay="{{ 80 + ($loop->index * 70) }}"
                        role="button"
                        tabindex="0"
                        @click="handleCardClick($event, '{{ $project['id'] }}')"
                        @keydown.enter.self.prevent="toggleProject('{{ $project['id'] }}', { source: 'keyboard' })"
                        @keydown.space.self.prevent="toggleProject('{{ $project['id'] }}', { source: 'keyboard' })"
                        :aria-expanded="isExpanded('{{ $project['id'] }}').toString()"
                        aria-controls="project-detail-{{ $project['id'] }}"
                    >
                        <div class="project-row" :class="{ 'project-row--expanded': isExpanded('{{ $project['id'] }}') }">

                            {{-- ── Media / story area ── --}}
                            <div class="project-row__preview" data-project-preview>

                                {{-- ── COLLAPSED: single cover thumbnail ── --}}
                                <div
                                    class="project-story-fallback"
                                    x-show="!isExpanded('{{ $project['id'] }}')"
                                    x-transition:leave="transition duration-280 ease-in"
                                    x-transition:leave-start="opacity-100"
                                    x-transition:leave-end="opacity-0"
                                    aria-hidden="true"
                                >
                                    <div class="project-story-fallback__media">
                                        @if ($leadMedia)
                                            @if (($leadMedia['type'] ?? 'image') === 'video')
                                                <video
                                                    class="h-full w-full object-cover"
                                                    autoplay muted loop playsinline preload="metadata"
                                                    @if (filled($leadMedia['poster'] ?? null)) poster="{{ $leadMedia['poster'] }}" @endif
                                                ><source src="{{ $leadMedia['src'] }}"@if (filled($leadMedia['mime'] ?? null)) type="{{ $leadMedia['mime'] }}"@endif></video>
                                            @else
                                                <img
                                                    src="{{ $leadMedia['src'] }}"
                                                    alt="{{ $leadMedia['alt'] }}"
                                                    class="h-full w-full object-cover"
                                                    loading="lazy"
                                                    decoding="async"
                                                >
                                            @endif
                                        @endif
                                    </div>
                                </div>

                                {{-- ── EXPANDED: horizontal snap-scroll story ──
                                     Scroll order (left → right):
                                       [1] Lead image    — full-width, shown first on open (scrollLeft = 0)
                                       [2] Details panel — title, spec, concept, location (swipe left to see)
                                       [3…] Secondary image panels (62% wide each)
                                --}}
                                <div
                                    class="project-story-view js-project-story-view"
                                    data-project-story-view
                                    x-show="isExpanded('{{ $project['id'] }}')"
                                    x-effect="
                                        if (isExpanded('{{ $project['id'] }}')) {
                                            $nextTick(() => { $el.scrollLeft = 0; });
                                        }
                                    "
                                >
                                    {{-- ── PANEL 1: Lead image — full-width, always first ── --}}
                                    @if ($leadMedia)
                                        <div class="project-story-panel--lead">
                                            @if (($leadMedia['type'] ?? 'image') === 'video')
                                                <video
                                                    class="h-full w-full object-cover"
                                                    autoplay muted loop playsinline preload="metadata"
                                                    @if (filled($leadMedia['poster'] ?? null)) poster="{{ $leadMedia['poster'] }}" @endif
                                                ><source src="{{ $leadMedia['src'] }}"@if (filled($leadMedia['mime'] ?? null)) type="{{ $leadMedia['mime'] }}"@endif></video>
                                            @else
                                                <img
                                                    src="{{ $leadMedia['src'] }}"
                                                    alt="{{ $leadMedia['alt'] }}"
                                                    class="h-full w-full object-cover"
                                                    loading="lazy"
                                                    decoding="async"
                                                >
                                            @endif
                                        </div>
                                    @endif

                                    {{-- ── PANEL 2: Project details — text panel, second in scroll ── --}}
                                    <div class="project-story-panel--details">

                                        {{-- Swipe hint pointing right toward images --}}
                                        <p class="swipe-hint" aria-hidden="true">
                                            More images
                                            <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M6 3l5 5-5 5"/>
                                            </svg>
                                        </p>

                                        <p class="project-story-copy__label">
                                            {{ $project['type_label'] }}
                                        </p>

                                        <h3 class="project-story-copy__title">
                                            {{ $project['title'] }}
                                        </h3>

                                        <div class="project-story-copy__fields">

                                            @if (filled($project['specification'] ?? null))
                                                <div class="project-story-copy__field">
                                                    <span class="project-story-copy__field-label">Specifications</span>
                                                    <span class="project-story-copy__field-value">{{ $project['specification'] }}</span>
                                                </div>
                                            @endif

                                            @if (filled($project['concept'] ?? null))
                                                <div class="project-story-copy__field">
                                                    <span class="project-story-copy__field-label">Concept</span>
                                                    <span class="project-story-copy__field-value">{{ $project['concept'] }}</span>
                                                </div>
                                            @endif

                                            @if (filled($project['location'] ?? null))
                                                <div class="project-story-copy__field">
                                                    <span class="project-story-copy__field-label">Location</span>
                                                    <span class="project-story-copy__field-value">{{ $project['location'] }}</span>
                                                </div>
                                            @endif

                                        </div>
                                    </div>{{-- /details panel --}}

                                    {{-- ── PANELS 3+: Secondary image-only panels ── --}}
                                    @foreach ($secondaryMedia as $media)
                                        <div class="project-story-panel">
                                            <div class="project-story-panel__media">
                                                @if (($media['type'] ?? 'image') === 'video')
                                                    <video
                                                        class="h-full w-full object-cover"
                                                        autoplay muted loop playsinline preload="metadata"
                                                        @if (filled($media['poster'] ?? null)) poster="{{ $media['poster'] }}" @endif
                                                    ><source src="{{ $media['src'] }}"@if (filled($media['mime'] ?? null)) type="{{ $media['mime'] }}"@endif></video>
                                                @else
                                                    <img
                                                        src="{{ $media['src'] }}"
                                                        alt="{{ $media['alt'] }}"
                                                        class="h-full w-full object-cover"
                                                        loading="lazy"
                                                        decoding="async"
                                                    >
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach

                                </div>{{-- /story-view --}}

                            </div>{{-- /preview --}}

                            {{-- ── Meta column — visible only when card is collapsed ── --}}
                            <div
                                class="project-row__meta"
                                :class="{ 'project-row__meta--hidden': isExpanded('{{ $project['id'] }}') }"
                                id="project-detail-{{ $project['id'] }}"
                            >
                                <div>
                                    <p
                                        class="project-row__type"
                                        x-text="activeCategory || '{{ addslashes($project['type_label']) }}'"
                                    >{{ $project['type_label'] }}</p>
                                    <h2 class="project-row__title">{{ $project['title'] }}</h2>
                                </div>

                                <div class="space-y-2">
                                    <p class="project-row__section-title">Specifications</p>
                                    <p class="project-row__detail">{{ $project['specification'] }}</p>
                                    <p class="project-row__detail">{{ $project['location'] }}</p>
                                </div>

                                <div
                                    class="project-concept-panel"
                                    :class="{ 'project-concept-panel--expanded': isExpanded('{{ $project['id'] }}') }"
                                    :aria-hidden="(!isExpanded('{{ $project['id'] }}')).toString()"
                                >
                                    <div class="project-concept-panel__inner">
                                        <p class="project-row__section-title">Concept</p>
                                        <p class="project-row__detail project-row__concept">{{ $project['concept'] }}</p>
                                    </div>
                                </div>
                            </div>

                        </div>{{-- /project-row --}}
                    </article>
                @endforeach
            </div>{{-- /project-list --}}

        </div>
    </div>
</section>

<script>
/**
 * Details-panel vertical scroll fix
 * ─────────────────────────────────
 * The horizontal snap-scroll container (.project-story-view) normally swallows
 * ALL wheel events, so the inner details panel can never scroll vertically via
 * mouse wheel or trackpad.
 *
 * Fix: intercept wheel events at capture phase. When the pointer is inside a
 * details panel AND the user is scrolling more vertically than horizontally,
 * we scroll the panel ourselves and prevent the event from reaching the
 * horizontal container.
 */
(function () {
    'use strict';

    document.addEventListener('wheel', function (e) {
        /** @type {HTMLElement|null} */
        var panel = e.target && e.target.closest
            ? e.target.closest('.project-story-panel--details')
            : null;

        if (!panel) return;

        var isVertical = Math.abs(e.deltaY) > Math.abs(e.deltaX);
        if (!isVertical) return;

        // Check whether the panel actually has overflowing content to scroll.
        var canScrollDown = e.deltaY > 0 && panel.scrollTop < (panel.scrollHeight - panel.clientHeight - 1);
        var canScrollUp   = e.deltaY < 0 && panel.scrollTop > 0;

        if (canScrollDown || canScrollUp) {
            // Take over: scroll the panel, block the horizontal container.
            e.stopPropagation();
            e.preventDefault();
            panel.scrollTop += e.deltaY;
        }
    }, { passive: false, capture: true });
}());
</script>





{{-- ======================================================================================================== --}}
{{-- Portfolio Section --}}
@php
    $portfolio = $portfolio ?? [];
    $isStandalone = $isStandalone ?? false;
    $heading = $portfolio['heading'] ?? [];
    $tabs = $portfolio['tabs'] ?? [];
    $projects = $portfolio['projects'] ?? [];

    $resolveMediaAsset = static function (mixed $asset, string $projectTitle, int $index): ?array {
        if (is_string($asset)) {
            $extension = strtolower(pathinfo($asset, PATHINFO_EXTENSION));
            $isVideo = in_array($extension, ['mp4', 'webm', 'ogg'], true);

            return [
                'type'   => $isVideo ? 'video' : 'image',
                'src'    => asset($asset),
                'poster' => null,
                'mime'   => $isVideo ? 'video/' . $extension : null,
                'alt'    => sprintf('%s image %d', $projectTitle, $index),
            ];
        }

        if (! is_array($asset) || ! filled($asset['src'] ?? null)) {
            return null;
        }

        $type = $asset['type'] ?? 'image';

        return [
            'type'   => $type,
            'src'    => asset($asset['src']),
            'poster' => filled($asset['poster'] ?? null) ? asset($asset['poster']) : null,
            'mime'   => $asset['mime'] ?? null,
            'alt'    => $asset['alt'] ?? sprintf('%s image %d', $projectTitle, $index),
        ];
    };

    // Prebuild asset urls for Alpine
    $interactiveProjects = collect($projects)
        ->map(function (array $project) use ($resolveMediaAsset): array {
            $gallery = collect($project['gallery'] ?? [])
                ->map(fn (mixed $asset, int $index): ?array => $resolveMediaAsset($asset, $project['title'], $index + 1))
                ->filter()
                ->values()
                ->all();

            return [
                ...$project,
                'cover_image' => data_get($gallery, '0.poster') ?? data_get($gallery, '0.src') ?? asset($project['cover_image']),
                'gallery'     => $gallery,
            ];
        })
        ->values()
        ->all();
@endphp

<style>
    /* ── Story view — horizontal scroll track ── */
.project-story-view {
    display: flex;
    overflow-x: auto;
    gap: 16px;
    scroll-snap-type: x mandatory;
    -webkit-overflow-scrolling: touch;
    height: 400px;
    scroll-behavior: smooth;

    /* IMPORTANT FIX */
    width: 100%;
    padding: 0;
    
    scrollbar-width: none;
    -ms-overflow-style: none;
}
.project-story-view::-webkit-scrollbar {
    display: none;
}

/* ── Each panel ── */
.project-story-panel {
    flex: 0 0 80%; /* FIX: use flex instead of min-width */
    scroll-snap-align: start;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    border-radius: inherit;
}

/* ── Media inside panel ── */
.project-story-panel__media {
    height: 400px;
    width: 100%;
    overflow: hidden;
    flex-shrink: 0;
}

.project-story-panel__media img,
.project-story-panel__media video {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* ── Lead panel (last one with details) ── */
.project-story-panel--lead {
    flex: 0 0 100%; /* FIX: full width */
    scroll-snap-align: start;
    display: flex;
    flex-direction: row;
    overflow: hidden;
    border-radius: inherit;
}

/* Left image (lead) */
.project-story-panel__media--lead {
    width: 55%;
    height: 400px;
    flex-shrink: 0;
    overflow: hidden;
}

.project-story-panel__media--lead img,
.project-story-panel__media--lead video {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* ── Right content ── */
.project-story-panel__copy {
    width: 45%;
    padding: 2rem 1.75rem;
    display: flex;
    flex-direction: column;
    gap: 1.25rem;
    overflow-y: auto;
    background: #faf7f2;
}

/* Title */
.project-story-panel__title {
    font-size: 1.35rem;
    font-weight: 600;
    line-height: 1.3;
    margin: 0.25rem 0 0;
}

/* ── Collapsed thumbnail ── */
.project-story-fallback {
    width: 100%;
    height: 100%;
    overflow: hidden;
}

.project-story-fallback__media {
    width: 100%;
    height: 100%;
}

.project-story-fallback__media img,
.project-story-fallback__media video {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* ── Hide meta when expanded ── */
.project-row__meta--hidden {
    display: none !important;
}

/* ── EXTRA: prevent right empty space ── */
.project-row__preview {
    width: 100%;
    overflow: hidden;
}
</style>

{{-- Portfolio --}}
<section
    x-data="projectsPortfolio(@js([
        'tabs'         => $tabs,
        'projects'     => $interactiveProjects,
        'isStandalone' => $isStandalone,
    ]))"
    @class([
        'portfolio-section',
        'portfolio-section--standalone' => $isStandalone,
        'portfolio-section--embedded'   => ! $isStandalone,
    ])
>
    <div class="mx-auto max-w-[1904px]">
        <div class="mx-auto max-w-[92rem] px-4 sm:px-6 lg:px-8">

            {{-- ── Header ── --}}
            @if ($isStandalone)
                <div class="projects-topbar" data-aos="fade-up">
                    <div class="projects-topbar__heading" aria-hidden="true">
                        <span>{{ $heading['eyebrow'] ?? 'OUR' }}</span>
                        <span>{{ $heading['title'] ?? 'PORTFOLIOS' }}</span>
                    </div>

                    <div class="projects-topbar__tabs">
                        @foreach ($tabs as $tab)
                            <button
                                type="button"
                                class="project-filter-tab"
                                data-active="{{ $loop->first ? 'true' : 'false' }}"
                                :class="{ 'project-filter-tab--active': activeCategory === '{{ $tab }}' }"
                                :data-active="activeCategory === '{{ $tab }}' ? 'true' : 'false'"
                                :aria-pressed="activeCategory === '{{ $tab }}' ? 'true' : 'false'"
                                @click="setCategory('{{ $tab }}')"
                            >
                                {{ $tab }}
                            </button>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="projects-topbar-embedded" data-aos="fade-up">
                    <div class="projects-topbar-embedded__heading" aria-hidden="true">
                        <span>{{ $heading['eyebrow'] ?? 'OUR' }}</span>
                        <span>{{ $heading['title'] ?? 'PORTFOLIOS' }}</span>
                    </div>

                    <div class="projects-topbar-embedded__tabs">
                        @foreach ($tabs as $tab)
                            <button
                                type="button"
                                class="project-filter-tab"
                                data-active="{{ $loop->first ? 'true' : 'false' }}"
                                :class="{ 'project-filter-tab--active': activeCategory === '{{ $tab }}' }"
                                :data-active="activeCategory === '{{ $tab }}' ? 'true' : 'false'"
                                :aria-pressed="activeCategory === '{{ $tab }}' ? 'true' : 'false'"
                                @click="setCategory('{{ $tab }}')"
                            >
                                {{ $tab }}
                            </button>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- ── Project list ── --}}
            <div
                class="project-list space-y-5 lg:space-y-6"
                :class="{
                    'project-list--compact':      visibleProjectCount() <= 2,
                    'project-list--single':       visibleProjectCount() <= 1,
                    'project-list--has-expanded': expandedProjectId !== null
                }"
            >
                <template x-if="visibleProjectCount() === 0">
                    <div class="rounded-[1.75rem] border border-black/8 bg-[#faf7f2] px-6 py-10 text-center text-[0.96rem] text-[#5f5f5f]">
                        No projects are available in this category yet.
                    </div>
                </template>

                @foreach ($interactiveProjects as $project)
                    @php
                        $leadMedia      = $project['gallery'][0] ?? null;
                        // Natural order: secondary panels first, lead panel (with details) last
                        $secondaryMedia = array_slice($project['gallery'], 1);
                    @endphp

                    <article
                        data-project-id="{{ $project['id'] }}"
                        x-show="isProjectVisible('{{ $project['id'] }}')"
                        x-transition:enter="transition duration-450 ease-[cubic-bezier(0.22,1,0.36,1)]"
                        x-transition:enter-start="opacity-0 translate-y-6 scale-[0.985]"
                        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                        x-transition:leave="transition duration-220 ease-[cubic-bezier(0.4,0,1,1)]"
                        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                        x-transition:leave-end="opacity-0 -translate-y-2 scale-[0.99]"
                        class="project-card"
                        :class="{ 'project-card--expanded': isExpanded('{{ $project['id'] }}') }"
                        data-aos="fade-up"
                        data-aos-duration="760"
                        data-aos-delay="{{ 80 + ($loop->index * 70) }}"
                        role="button"
                        tabindex="0"
                        @click="handleCardClick($event, '{{ $project['id'] }}')"
                        @keydown.enter.self.prevent="toggleProject('{{ $project['id'] }}', { source: 'keyboard' })"
                        @keydown.space.self.prevent="toggleProject('{{ $project['id'] }}', { source: 'keyboard' })"
                        :aria-expanded="isExpanded('{{ $project['id'] }}').toString()"
                        aria-controls="project-detail-{{ $project['id'] }}"
                    >
                        <div class="project-row" :class="{ 'project-row--expanded': isExpanded('{{ $project['id'] }}') }">

                            {{-- ── Media preview — IDENTICAL layout for both home + standalone ── --}}
                            <div class="project-row__preview" data-project-preview>

                                {{-- Collapsed: lead thumbnail --}}
                                <div
                                    class="project-story-fallback"
                                    x-show="!isExpanded('{{ $project['id'] }}')"
                                    aria-hidden="true"
                                >
                                    <div class="project-story-fallback__media">
                                        @if ($leadMedia)
                                            @if (($leadMedia['type'] ?? 'image') === 'video')
                                                <video
                                                    class="h-full w-full object-cover"
                                                    autoplay muted loop playsinline preload="metadata"
                                                    @if (filled($leadMedia['poster'] ?? null)) poster="{{ $leadMedia['poster'] }}" @endif
                                                >
                                                    <source
                                                        src="{{ $leadMedia['src'] }}"
                                                        @if (filled($leadMedia['mime'] ?? null)) type="{{ $leadMedia['mime'] }}" @endif
                                                    >
                                                </video>
                                            @else
                                                <img
                                                    src="{{ $leadMedia['src'] }}"
                                                    alt="{{ $leadMedia['alt'] }}"
                                                    class="h-full w-full object-cover"
                                                    loading="lazy"
                                                    decoding="async"
                                                >
                                            @endif
                                        @endif
                                    </div>
                                </div>

                                {{-- Expanded: horizontal story scroll, auto-scrolls to lead panel (details) --}}
                                <div
                                    class="project-story-view js-project-story-view"
                                    data-project-story-view
                                    x-show="isExpanded('{{ $project['id'] }}')"
                                    x-transition:enter="transition duration-400 ease-[cubic-bezier(0.22,1,0.36,1)]"
                                    x-transition:enter-start="opacity-0"
                                    x-transition:enter-end="opacity-100"
                                    x-transition:leave="transition duration-200 ease-out"
                                    x-transition:leave-start="opacity-100"
                                    x-transition:leave-end="opacity-0"
                                    x-effect="
                                        if (isExpanded('{{ $project['id'] }}')) {
                                            $nextTick(() => { $el.scrollLeft = $el.scrollWidth; });
                                        }
                                    "
                                >
                                    {{-- Secondary media panels --}}
                                    @foreach ($secondaryMedia as $media)
                                        <div class="project-story-panel">
                                            <div class="project-story-panel__media">
                                                @if (($media['type'] ?? 'image') === 'video')
                                                    <video
                                                        class="h-full w-full object-cover"
                                                        autoplay muted loop playsinline preload="metadata"
                                                        @if (filled($media['poster'] ?? null)) poster="{{ $media['poster'] }}" @endif
                                                    >
                                                        <source
                                                            src="{{ $media['src'] }}"
                                                            @if (filled($media['mime'] ?? null)) type="{{ $media['mime'] }}" @endif
                                                        >
                                                    </video>
                                                @else
                                                    <img
                                                        src="{{ $media['src'] }}"
                                                        alt="{{ $media['alt'] }}"
                                                        class="h-full w-full object-cover"
                                                        loading="lazy"
                                                        decoding="async"
                                                    >
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach

                                    {{-- Lead panel: cover image left + title / details right --}}
                                    @if ($leadMedia)
                                        <div class="project-story-panel project-story-panel--lead">
                                            <div class="project-story-panel__media project-story-panel__media--lead">
                                                @if (($leadMedia['type'] ?? 'image') === 'video')
                                                    <video
                                                        class="h-full w-full object-cover"
                                                        autoplay muted loop playsinline preload="metadata"
                                                        @if (filled($leadMedia['poster'] ?? null)) poster="{{ $leadMedia['poster'] }}" @endif
                                                    >
                                                        <source
                                                            src="{{ $leadMedia['src'] }}"
                                                            @if (filled($leadMedia['mime'] ?? null)) type="{{ $leadMedia['mime'] }}" @endif
                                                        >
                                                    </video>
                                                @else
                                                    <img
                                                        src="{{ $leadMedia['src'] }}"
                                                        alt="{{ $leadMedia['alt'] }}"
                                                        class="h-full w-full object-cover"
                                                        loading="lazy"
                                                        decoding="async"
                                                    >
                                                @endif
                                            </div>

                                            {{-- Details: always visible when card is expanded --}}
                                            <div class="project-story-panel__copy">
                                                <p class="project-row__type">{{ $project['type_label'] }}</p>
                                                <h3 class="project-story-panel__title">{{ $project['title'] }}</h3>

                                                <div class="space-y-5">
                                                    <div class="space-y-1.5">
                                                        <p class="project-row__section-title">Specifications</p>
                                                        <p class="project-row__detail">{{ $project['specification'] }}</p>
                                                    </div>

                                                    <div class="space-y-1.5">
                                                        <p class="project-row__section-title">Concept</p>
                                                        <p class="project-row__detail">{{ $project['concept'] }}</p>
                                                    </div>

                                                    <div class="space-y-1.5">
                                                        <p class="project-row__section-title">Location</p>
                                                        <p class="project-row__detail">{{ $project['location'] }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                </div>

                            </div>

                            {{-- ── Meta column: shown when collapsed, hidden when expanded ──
                                 When expanded, all details are inside the story lead panel above --}}
                            <div
                                class="project-row__meta"
                                :class="{ 'project-row__meta--hidden': isExpanded('{{ $project['id'] }}') }"
                                id="project-detail-{{ $project['id'] }}"
                            >
                                <div>
                                    <p
                                        class="project-row__type"
                                        x-text="activeCategory || '{{ addslashes($project['type_label']) }}'"
                                    >{{ $project['type_label'] }}</p>
                                    <h2 class="project-row__title">{{ $project['title'] }}</h2>
                                </div>

                                <div class="space-y-2">
                                    <p class="project-row__section-title">Specifications</p>
                                    <p class="project-row__detail">{{ $project['specification'] }}</p>
                                    <p class="project-row__detail">{{ $project['location'] }}</p>
                                </div>

                                <div
                                    class="project-concept-panel"
                                    :class="{ 'project-concept-panel--expanded': isExpanded('{{ $project['id'] }}') }"
                                    :aria-hidden="(!isExpanded('{{ $project['id'] }}')).toString()"
                                >
                                    <div class="project-concept-panel__inner">
                                        <p class="project-row__section-title">Concept</p>
                                        <p class="project-row__detail project-row__concept">{{ $project['concept'] }}</p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </article>
                @endforeach
            </div>

        </div>
    </div>
</section>

<script>
    $nextTick(() => {
    const last = $el.lastElementChild;
    if (last) {
        last.scrollIntoView({ behavior: 'smooth', inline: 'start' });
    }
});
</script>