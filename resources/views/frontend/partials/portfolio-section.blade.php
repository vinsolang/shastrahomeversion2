@php
    $portfolio = $portfolio ?? [];
    $isStandalone = $isStandalone ?? false;
    $heading = $portfolio['heading'] ?? [];
    $tabs = $portfolio['tabs'] ?? [];
    $projects = $portfolio['projects'] ?? [];
    // Prebuild asset urls for Alpine
    $interactiveProjects = collect($projects)
        ->map(function (array $project): array {
            $gallery = collect($project['gallery'] ?? [])
                ->map(static fn (string $imagePath): string => asset($imagePath))
                ->values()
                ->all();

            return [
                ...$project,
                'cover_image' => asset($project['cover_image']),
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
                                :class="{ 'project-filter-tab--active': activeCategory === '{{ $tab }}' }"
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
                                :class="{ 'project-filter-tab--active': activeCategory === '{{ $tab }}' }"
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
                }"
            >
                <template x-if="visibleProjectCount() === 0">
                    <div class="rounded-[1.75rem] border border-black/8 bg-[#faf7f2] px-6 py-10 text-center text-[0.96rem] text-[#5f5f5f]">
                        No projects are available in this category yet.
                    </div>
                </template>

                @foreach ($projects as $project)
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
                        {{-- Keep the card toggle off the swiper controls --}}
                        @click="if (! $event.target.closest('[data-gallery-control]')) { toggleProject('{{ $project['id'] }}'); }"
                        @keydown.enter.self.prevent="toggleProject('{{ $project['id'] }}')"
                        @keydown.space.self.prevent="toggleProject('{{ $project['id'] }}')"
                        :aria-expanded="isExpanded('{{ $project['id'] }}').toString()"
                        aria-controls="project-detail-{{ $project['id'] }}"
                    >
                        {{-- Project --}}
                        <div class="project-row" :class="{ 'project-row--expanded': isExpanded('{{ $project['id'] }}') }">
                            <div class="project-row__preview">
                                <div class="swiper project-swiper js-project-swiper">
                                    <div class="swiper-wrapper">
                                        @foreach ($project['gallery'] as $image)
                                            <div class="swiper-slide">
                                                <img
                                                    src="{{ asset($image) }}"
                                                    alt="{{ $project['title'] }} image {{ $loop->iteration }}"
                                                    class="h-full w-full object-cover"
                                                    loading="lazy"
                                                    decoding="async"
                                                >
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

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
                            </div>
                            <div
                                class="project-row__meta"
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

                                <div class="project-row__footer flex items-center justify-between gap-4 pt-4">
                                    <p
                                        x-cloak
                                        x-show="isExpanded('{{ $project['id'] }}')"
                                        x-transition.opacity.duration.200ms
                                        class="text-[0.74rem] uppercase tracking-[0.28em] text-[#9b9b9b]"
                                    >
                                        Swipe and arrows
                                    </p>

                                    <span
                                        class="inline-flex h-11 w-11 items-center justify-center rounded-full border border-[#ff8800]/35 text-[#ff8800] transition-transform duration-200"
                                        :class="{ 'rotate-180': isExpanded('{{ $project['id'] }}') }"
                                        aria-hidden="true"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="m6 9 6 6 6-6" />
                                        </svg>
                                    </span>
                                </div>
                            </div>

                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </div>
</section>
