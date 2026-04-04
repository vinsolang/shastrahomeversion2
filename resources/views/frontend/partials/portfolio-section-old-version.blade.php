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
                'type' => $isVideo ? 'video' : 'image',
                'src' => asset($asset),
                'poster' => null,
                'mime' => $isVideo ? 'video/' . $extension : null,
                'alt' => sprintf('%s image %d', $projectTitle, $index),
            ];
        }

        if (! is_array($asset) || ! filled($asset['src'] ?? null)) {
            return null;
        }

        $type = $asset['type'] ?? 'image';

        return [
            'type' => $type,
            'src' => asset($asset['src']),
            'poster' => filled($asset['poster'] ?? null) ? asset($asset['poster']) : null,
            'mime' => $asset['mime'] ?? null,
            'alt' => $asset['alt'] ?? sprintf('%s image %d', $projectTitle, $index),
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
                'gallery' => $gallery,
            ];
        })
        ->values()
        ->all();
@endphp

{{-- Portfolio --}}
<section
    x-data="projectsPortfolio(@js([
        'tabs' => $tabs,
        'projects' => $interactiveProjects,
        'isStandalone' => $isStandalone,
    ]))"
    @class([
        'portfolio-section',
        'portfolio-section--standalone' => $isStandalone,
        'portfolio-section--embedded' => ! $isStandalone,
    ])
>
    <div class="mx-auto max-w-[1904px]">
        <div class="mx-auto max-w-[92rem] px-4 sm:px-6 lg:px-8">
            {{-- Header --}}
            @if ($isStandalone)
                <div class="projects-topbar" data-aos="fade-up">
                    <div class="projects-topbar__heading" aria-hidden="true">
                        <span>{{ $heading['eyebrow'] ?? 'OUR' }}</span>
                        <span>{{ $heading['title'] ?? 'PORTFOLIO' }}</span>
                    </div>

                    {{-- Tabs --}}
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
                        <span>{{ $heading['title'] ?? 'PORTFOLIO' }}</span>
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

            {{-- List --}}
            <div
                class="project-list space-y-5 lg:space-y-6"
                :class="{
                    'project-list--compact': visibleProjectCount() <= 2,
                    'project-list--single': visibleProjectCount() <= 1,
                    'project-list--has-expanded': expandedProjectId !== null
                }"
            >
                <template x-if="visibleProjectCount() === 0">
                    <div class="rounded-[1.75rem] border border-black/8 bg-[#faf7f2] px-6 py-10 text-center text-[0.96rem] text-[#5f5f5f]">
                        No projects are available in this category yet.
                    </div>
                </template>

                @foreach ($interactiveProjects as $project)
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
                        @unless ($isStandalone)
                            data-aos="fade-up"
                            data-aos-duration="760"
                            data-aos-delay="{{ 80 + ($loop->index * 70) }}"
                        @endunless
                        role="button"
                        tabindex="0"
                        {{-- Keep the card toggle off the swiper controls --}}
                        @click="handleCardClick($event, '{{ $project['id'] }}')"
                        @keydown.enter.self.prevent="toggleProject('{{ $project['id'] }}', { source: 'keyboard' })"
                        @keydown.space.self.prevent="toggleProject('{{ $project['id'] }}', { source: 'keyboard' })"
                        :aria-expanded="isExpanded('{{ $project['id'] }}').toString()"
                        aria-controls="project-detail-{{ $project['id'] }}"
                    >
                        {{-- Project --}}
                        <div class="project-row" :class="{ 'project-row--expanded': isExpanded('{{ $project['id'] }}') }">
                            <div class="project-row__preview" data-project-preview>
                                @if ($isStandalone)
                                    @php
                                        $leadMedia = $project['gallery'][0] ?? null;
                                        $secondaryMedia = array_reverse(array_slice($project['gallery'], 1));
                                    @endphp

                                    <div class="project-story-fallback" aria-hidden="true">
                                        <div class="project-story-fallback__media">
                                            @if ($leadMedia)
                                                @if (($leadMedia['type'] ?? 'image') === 'video')
                                                    <video
                                                        class="h-full w-full object-cover"
                                                        autoplay
                                                        muted
                                                        loop
                                                        playsinline
                                                        preload="metadata"
                                                        @if (filled($leadMedia['poster'] ?? null))
                                                            poster="{{ $leadMedia['poster'] }}"
                                                        @endif
                                                    >
                                                        <source
                                                            src="{{ $leadMedia['src'] }}"
                                                            @if (filled($leadMedia['mime'] ?? null))
                                                                type="{{ $leadMedia['mime'] }}"
                                                            @endif
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

                                    <div class="project-story-view js-project-story-view" data-project-story-view>
                                        @foreach ($secondaryMedia as $media)
                                            <div class="project-story-panel">
                                                <div class="project-story-panel__media">
                                                    @if (($media['type'] ?? 'image') === 'video')
                                                        <video
                                                            class="h-full w-full object-cover"
                                                            autoplay
                                                            muted
                                                            loop
                                                            playsinline
                                                            preload="metadata"
                                                            @if (filled($media['poster'] ?? null))
                                                                poster="{{ $media['poster'] }}"
                                                            @endif
                                                        >
                                                            <source
                                                                src="{{ $media['src'] }}"
                                                                @if (filled($media['mime'] ?? null))
                                                                    type="{{ $media['mime'] }}"
                                                                @endif
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

                                        @if ($leadMedia)
                                            <div class="project-story-panel project-story-panel--lead">
                                                <div class="project-story-panel__media project-story-panel__media--lead">
                                                    @if (($leadMedia['type'] ?? 'image') === 'video')
                                                        <video
                                                            class="h-full w-full object-cover"
                                                            autoplay
                                                            muted
                                                            loop
                                                            playsinline
                                                            preload="metadata"
                                                            @if (filled($leadMedia['poster'] ?? null))
                                                                poster="{{ $leadMedia['poster'] }}"
                                                            @endif
                                                        >
                                                            <source
                                                                src="{{ $leadMedia['src'] }}"
                                                                @if (filled($leadMedia['mime'] ?? null))
                                                                    type="{{ $leadMedia['mime'] }}"
                                                                @endif
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
                                @else
                                    <div class="swiper project-swiper js-project-swiper">
                                        <div class="swiper-wrapper">
                                            @foreach ($project['gallery'] as $media)
                                                <div class="swiper-slide project-story-slide project-story-slide--media @if ($loop->first) project-story-slide--media-primary @endif">
                                                    <div class="project-story-slide__media">
                                                        @if (($media['type'] ?? 'image') === 'video')
                                                            <video
                                                                class="h-full w-full object-cover"
                                                                autoplay
                                                                muted
                                                                loop
                                                                playsinline
                                                                preload="metadata"
                                                                @if (filled($media['poster'] ?? null))
                                                                    poster="{{ $media['poster'] }}"
                                                                @endif
                                                            >
                                                                <source
                                                                    src="{{ $media['src'] }}"
                                                                    @if (filled($media['mime'] ?? null))
                                                                        type="{{ $media['mime'] }}"
                                                                    @endif
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
                                        </div>
                                    </div>
                                @endif

                                @if (! $isStandalone)
                                    <div
                                        x-cloak
                                        x-show="isExpanded('{{ $project['id'] }}')"
                                        x-transition:enter="transition duration-400 ease-[cubic-bezier(0.22,1,0.36,1)]"
                                        x-transition:enter-start="opacity-0 -translate-y-2"
                                        x-transition:enter-end="opacity-100 translate-y-0"
                                        x-transition:leave="transition duration-250 ease-out"
                                        x-transition:leave-start="opacity-100 translate-y-0"
                                        x-transition:leave-end="opacity-0 -translate-y-1"
                                        class="pointer-events-none absolute inset-x-0 top-0 flex items-start justify-end p-4 sm:p-5"
                                    >
                                        <p class="project-gallery-counter" aria-live="polite">
                                            <span data-project-swiper-current>1</span>
                                            <span>/</span>
                                            <span>{{ count($project['gallery']) }}</span>
                                        </p>
                                    </div>
                                @endif

                                @unless ($isStandalone)
                                    <div
                                        x-cloak
                                        x-show="isExpanded('{{ $project['id'] }}')"
                                        x-transition:enter="transition duration-450 ease-[cubic-bezier(0.22,1,0.36,1)]"
                                        x-transition:enter-start="opacity-0"
                                        x-transition:enter-end="opacity-100"
                                        x-transition:leave="transition duration-250 ease-out"
                                        x-transition:leave-start="opacity-100"
                                        x-transition:leave-end="opacity-0"
                                        class="pointer-events-none absolute inset-x-0 bottom-0 h-24 bg-[linear-gradient(180deg,rgba(12,12,12,0)_0%,rgba(12,12,12,0.72)_100%)]"
                                    ></div>
                                @endunless

                                @unless ($isStandalone)
                                    <div
                                        x-cloak
                                        x-show="isExpanded('{{ $project['id'] }}')"
                                        x-transition:enter="transition duration-450 ease-[cubic-bezier(0.22,1,0.36,1)] delay-75"
                                        x-transition:enter-start="opacity-0"
                                        x-transition:enter-end="opacity-100"
                                        x-transition:leave="transition duration-250 ease-out"
                                        x-transition:leave-start="opacity-100"
                                        x-transition:leave-end="opacity-0"
                                        class="absolute inset-0 flex items-center justify-between px-4 sm:px-5"
                                    >
                                        <button
                                            type="button"
                                            class="project-gallery-control project-gallery-control--previous js-project-swiper-prev"
                                            data-gallery-control
                                            @click.stop
                                            aria-label="Show previous image for {{ $project['title'] }}"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 19l-7-7 7-7" />
                                            </svg>
                                        </button>

                                        <button
                                            type="button"
                                            class="project-gallery-control project-gallery-control--next js-project-swiper-next"
                                            data-gallery-control
                                            @click.stop
                                            aria-label="Show next image for {{ $project['title'] }}"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="m9 5 7 7-7 7" />
                                            </svg>
                                        </button>
                                    </div>
                                @endunless
                            </div>
                            <div
                                class="project-row__meta"
                                :class="{ 'project-row__meta--standalone-hidden': isExpanded('{{ $project['id'] }}') && {{ $isStandalone ? 'true' : 'false' }} }"
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