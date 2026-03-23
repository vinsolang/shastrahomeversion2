@extends('layouts.marketing')

@section('title', 'Shastra | ' . $page['title'])
@section('meta_description', $page['description'])

@section('content')
    @php
        $story = $page['story'] ?? [];
        $philosophy = $page['philosophy'] ?? [];
        $coreValues = $page['core_values'] ?? [];
        $founder = $page['founder'] ?? [];
        $downloadCta = $story['download_cta'] ?? [];
        $storyBackgroundVideo = $story['background_video'] ?? null;
        $storyBackgroundImage = $story['background_image'] ?? null;
        $storyTitle = $story['title'] ?? $page['title'];
        $storyParagraphs = $story['paragraphs'] ?? [];
        $downloadLabel = $downloadCta['label'] ?? null;
        $downloadIcon = $downloadCta['icon'] ?? null;
        $downloadHref = (($downloadCta['available'] ?? false) && filled($downloadCta['href'] ?? null))
            ? $downloadCta['href']
            : null;
        $coreValueItems = $coreValues['items'] ?? [];
        $founderName = $founder['name'] ?? '';
        $founderRole = $founder['role'] ?? '';
    @endphp

    <div class="bg-white text-[#1f1f1f]">
        {{-- Hero --}}
        <section class="overflow-hidden bg-white">
            <div class="mx-auto max-w-[1904px]">
                <div class="relative min-h-[30rem] overflow-hidden sm:min-h-[33rem] lg:h-[48rem] lg:min-h-[48rem] xl:h-[49.5rem] xl:min-h-[49.5rem]">
                    @if (filled($storyBackgroundVideo))
                        <div class="absolute inset-x-0 top-0 h-[14.5rem] overflow-hidden sm:h-[18rem] lg:inset-y-0 lg:left-[18.75rem] lg:right-0 lg:h-auto" data-aos="fade-left" data-aos-duration="780">
                            <video
                                class="absolute inset-0 h-full w-full object-cover"
                                autoplay
                                muted
                                loop
                                playsinline
                                preload="metadata"
                            >
                                <source src="{{ asset($storyBackgroundVideo) }}" type="video/mp4">
                            </video>
                        </div>
                    @elseif (filled($storyBackgroundImage))
                        <div class="absolute inset-x-0 top-0 h-[14.5rem] overflow-hidden sm:h-[18rem] lg:inset-y-0 lg:left-[18.75rem] lg:right-0 lg:h-auto" data-aos="fade-left" data-aos-duration="780">
                            <img
                                src="{{ asset($storyBackgroundImage) }}"
                                alt=""
                                class="about-hero-media h-full w-full object-cover object-[62%_center] lg:object-cover lg:object-center"
                                decoding="async"
                            >
                        </div>
                    @endif

                    {{-- Card --}}
                    <div
                        class="about-hero-card absolute left-3 top-[8.9rem] z-20 w-[calc(100%-1.5rem)] sm:left-6 sm:top-[11rem] sm:w-[min(34rem,calc(100%-3rem))] lg:left-[6.25rem] lg:top-[7.1rem] lg:w-[61.5rem] xl:left-[6.4rem] xl:top-[7.45rem] xl:w-[66rem]"
                        data-aos="fade-up"
                        data-aos-duration="760"
                    >
                        <div class="bg-[#ff8a00] px-4 py-4 shadow-[0_26px_40px_rgba(0,0,0,0.14)] sm:px-6 sm:py-5 lg:px-[3.35rem] lg:py-[2.65rem] xl:px-[3.55rem] xl:py-[2.8rem]">
                            <h1 class="font-sans text-[1.55rem] leading-none font-light tracking-[-0.03em] text-[#1f1f1f] sm:text-[2rem] lg:text-[3.2rem] xl:text-[3.4rem]">
                                {{ $storyTitle }}
                            </h1>

                            {{-- Story --}}
                            <div class="mt-4 max-w-[49rem] pr-2 space-y-4 text-[0.78rem] leading-[1.26] text-white sm:mt-5 sm:max-w-[31rem] sm:pr-3 sm:space-y-5 sm:text-[0.92rem] sm:leading-[1.28] lg:mt-8 lg:max-w-[56rem] lg:pr-[3.5rem] lg:space-y-6 lg:text-[1.15rem] lg:leading-[1.14] xl:max-w-[60rem] xl:pr-[4.5rem] xl:text-[1.16rem]">
                                @foreach ($storyParagraphs as $paragraph)
                                    <p>{{ $paragraph }}</p>
                                @endforeach
                            </div>

                            @if (filled($downloadLabel))
                                {{-- Action --}}
                                <div class="mt-5 sm:mt-6 lg:mt-9">
                                    @if ($downloadHref)
                                        <a
                                            href="{{ $downloadHref }}"
                                            class="inline-flex min-h-[3rem] w-full items-center justify-center gap-3 bg-[#1f1f1f] px-4 text-[0.86rem] font-semibold text-[#ff9b0f] transition hover:bg-black sm:min-h-[3.35rem] sm:w-auto sm:px-6 sm:text-[0.92rem] lg:min-h-[4.1rem] lg:px-8 lg:text-[1rem]"
                                        >
                                            @if (filled($downloadIcon))
                                                <img
                                                    src="{{ asset($downloadIcon) }}"
                                                    alt=""
                                                    class="h-4 w-4 object-contain [filter:brightness(0)_saturate(100%)_invert(63%)_sepia(99%)_saturate(1772%)_hue-rotate(3deg)_brightness(101%)_contrast(103%)] sm:h-5 sm:w-5 lg:h-6 lg:w-6"
                                                    loading="lazy"
                                                    decoding="async"
                                                >
                                            @endif
                                            <span>{{ $downloadLabel }}</span>
                                        </a>
                                    @else
                                        <button
                                            type="button"
                                            class="inline-flex min-h-[3rem] w-full items-center justify-center gap-3 bg-[#1f1f1f] px-4 text-[0.86rem] font-semibold text-[#ff9b0f] transition hover:bg-black hover:shadow-[0_10px_20px_rgba(0,0,0,0.18)] focus:outline-none focus:ring-2 focus:ring-black/25 sm:min-h-[3.35rem] sm:w-auto sm:px-6 sm:text-[0.92rem] lg:min-h-[4.1rem] lg:px-8 lg:text-[1rem]"
                                        >
                                            @if (filled($downloadIcon))
                                                <img
                                                    src="{{ asset($downloadIcon) }}"
                                                    alt=""
                                                    class="h-4 w-4 object-contain [filter:brightness(0)_saturate(100%)_invert(63%)_sepia(99%)_saturate(1772%)_hue-rotate(3deg)_brightness(101%)_contrast(103%)] sm:h-5 sm:w-5 lg:h-6 lg:w-6"
                                                    loading="lazy"
                                                    decoding="async"
                                                >
                                            @endif
                                            <span>{{ $downloadLabel }}</span>
                                        </button>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <div class="mt-3 h-3 bg-[#1f1f1f] lg:mt-0 lg:ml-[12.5rem] lg:h-6 xl:ml-[12.35rem]" aria-hidden="true"></div>
                    </div>

                </div>
            </div>
        </section>

        {{-- Philosophy --}}
        <section class="bg-white py-10 sm:py-12 xl:py-[4.5rem]">
            <div class="mx-auto max-w-[1904px]">
                <div class="mx-auto max-w-[76rem] px-4 sm:px-6 md:px-8">
                    <p
                        class="text-[0.8rem] font-medium uppercase tracking-[0.42em] text-[#ff8800] sm:text-[0.9rem] xl:ml-[4rem]"
                        data-aos="fade-up"
                    >
                        {{ $philosophy['eyebrow'] ?? '' }}
                    </p>

                    <div class="mx-auto mt-5 grid max-w-[66rem] gap-4 xl:grid-cols-2 xl:gap-5">
                        <article
                            class="group bg-[#1f1f1f] px-5 py-6 text-white shadow-[0_22px_45px_rgba(0,0,0,0.12)] transition-[background-color,color,transform,box-shadow] duration-200 hover:-translate-y-1 hover:bg-[#ff8800] hover:text-[#1f1f1f] hover:shadow-[0_28px_50px_rgba(0,0,0,0.16)] sm:px-7 sm:py-7 xl:min-h-[17rem] xl:px-8 xl:py-8"
                            data-aos="fade-up"
                            data-aos-delay="60"
                        >
                            <h2 class="font-display text-[2rem] leading-none font-semibold tracking-[-0.04em] text-white transition-colors duration-200 group-hover:text-[#1f1f1f] sm:text-[2.4rem]">
                                {{ $philosophy['mission']['title'] ?? '' }}
                            </h2>

                            <p class="mt-5 text-[0.98rem] leading-[1.72] text-white/84 transition-colors duration-200 group-hover:text-[#1f1f1f]/88 sm:text-[1.04rem]">
                                {{ $philosophy['mission']['description'] ?? '' }}
                            </p>
                        </article>

                        <article
                            class="group bg-[#1f1f1f] px-5 py-6 text-white shadow-[0_22px_45px_rgba(0,0,0,0.12)] transition-[background-color,color,transform,box-shadow] duration-200 hover:-translate-y-1 hover:bg-[#ff8800] hover:text-[#1f1f1f] hover:shadow-[0_28px_50px_rgba(0,0,0,0.16)] sm:px-7 sm:py-7 xl:min-h-[17rem] xl:px-8 xl:py-8"
                            data-aos="fade-up"
                            data-aos-delay="140"
                        >
                            <h2 class="font-display text-[2rem] leading-none font-semibold tracking-[-0.04em] text-white transition-colors duration-200 group-hover:text-[#1f1f1f] sm:text-[2.4rem]">
                                {{ $philosophy['vision']['title'] ?? '' }}
                            </h2>

                            <p class="mt-5 text-[0.98rem] leading-[1.72] text-white/84 transition-colors duration-200 group-hover:text-[#1f1f1f]/88 sm:text-[1.04rem]">
                                {{ $philosophy['vision']['description'] ?? '' }}
                            </p>
                        </article>
                    </div>
                </div>
            </div>
        </section>

        {{-- Values --}}
        <section class="bg-white pt-10 sm:pt-12 xl:pt-[4.5rem]">
            <div class="mx-auto max-w-[1904px]">
                <div class="mx-auto max-w-[76rem] px-4 sm:px-6 md:px-8">
                    <div class="max-w-[42rem] xl:ml-[2.85rem]" data-aos="fade-up">
                        <h2 class="font-sans text-[2rem] leading-[0.96] font-normal tracking-[-0.04em] text-[#ff8800] sm:text-[2.45rem] xl:text-[2.7rem]">
                            {{ $coreValues['title'] ?? '' }}
                        </h2>

                        <p class="mt-2 max-w-[35rem] text-[0.82rem] leading-[1.3] text-[#4a4a4a] sm:text-[0.9rem] xl:text-[0.96rem]">
                            {{ $coreValues['intro'] ?? '' }}
                        </p>
                    </div>
                </div>

                {{-- Grid --}}
                <div class="relative mt-5 overflow-hidden bg-[#171717] sm:mt-7">
                    @if (filled($coreValues['background_image'] ?? null))
                        <img
                            src="{{ asset($coreValues['background_image']) }}"
                            alt=""
                            class="absolute inset-0 h-full w-full object-cover object-center"
                            loading="lazy"
                            decoding="async"
                        >
                    @endif

                    <div class="absolute inset-0 bg-[rgba(16,16,16,0.18)]"></div>

                    <div class="relative z-10 mx-auto max-w-[1904px] px-4 py-8 sm:px-6 sm:py-10 md:px-8 xl:px-[clamp(2rem,8vw,9.5rem)] xl:py-[4.25rem]">
                        <div class="mx-auto grid max-w-[76rem] gap-5 xl:grid-cols-2 xl:auto-rows-[11.6rem] xl:gap-x-[4.2rem] xl:gap-y-9">
                            @foreach ($coreValueItems as $item)
                                <article
                                    class="about-core-card relative h-full min-h-[8.25rem] bg-[rgba(12,12,12,0.88)] px-5 py-5 text-white shadow-[0_20px_36px_rgba(0,0,0,0.18)] backdrop-blur-[1px] after:absolute after:inset-x-0 after:bottom-0 after:h-[6px] after:origin-left after:scale-x-0 after:bg-[#ff8800] after:transition-transform after:duration-200 after:content-[''] hover:after:scale-x-100 sm:px-7 sm:py-6 xl:px-[2.7rem] xl:py-[2.15rem]"
                                    data-aos="fade-up"
                                    data-aos-delay="{{ 80 + ($loop->index * 70) }}"
                                >
                                    <div class="grid items-start gap-4 xl:grid-cols-[4.5rem_minmax(0,1fr)] xl:gap-6">
                                        @if (filled($item['icon'] ?? null))
                                            <img
                                                src="{{ asset($item['icon']) }}"
                                                alt=""
                                                class="about-core-icon mt-1 h-8 w-auto shrink-0 object-contain xl:mt-[0.35rem] xl:h-10 xl:justify-self-start"
                                                loading="lazy"
                                                decoding="async"
                                            >
                                        @endif

                                        <div class="about-core-copy min-w-0">
                                            <h3 class="text-[1.35rem] leading-[1.08] font-normal tracking-[-0.02em] text-[#ff8800] sm:text-[1.6rem] xl:mt-[0.1rem] xl:text-[2.05rem]">
                                                {{ $item['title'] ?? '' }}
                                            </h3>

                                            <p class="mt-2 text-[0.95rem] leading-[1.35] text-white/78 sm:text-[1rem] xl:text-[1.1rem]">
                                                {{ $item['description'] ?? '' }}
                                            </p>
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Founder --}}
        <section class="bg-white py-10 sm:py-12 xl:py-[4.5rem]">
            <div class="mx-auto max-w-[1904px]">
                <div class="mx-auto grid max-w-[76rem] gap-6 px-4 sm:px-6 md:px-8 xl:max-w-[85rem] xl:grid-cols-[18.5rem_minmax(0,1fr)] xl:items-stretch xl:gap-[0.65rem]">
                    {{-- Portrait --}}
                    <div
                        class="relative overflow-hidden bg-[#ff8800] px-5 pt-6 sm:px-7 xl:min-h-[23rem] xl:overflow-visible xl:px-0 xl:pt-0"
                        data-aos="fade-right"
                    >
                        @if (filled($founder['image'] ?? null))
                            <img
                                src="{{ asset($founder['image']) }}"
                                alt="{{ $founder['name'] ?? 'Founder portrait' }}"
                                class="mx-auto h-auto max-h-[25.5rem] w-auto object-contain xl:absolute xl:bottom-0 xl:left-1/2 xl:max-h-[25.5rem] xl:w-auto xl:max-w-none xl:-translate-x-[48%]"
                                loading="lazy"
                                decoding="async"
                            >
                        @endif
                    </div>

                    {{-- Quote --}}
                    <article
                        class="flex flex-col justify-between bg-[#1f1f1f] px-5 py-7 text-white sm:px-7 sm:py-8 xl:min-h-[23rem] xl:pl-[6.5rem] xl:pr-[4rem] xl:py-[3.45rem]"
                        data-aos="fade-left"
                        data-aos-delay="80"
                    >
                        <div>
                            <p class="font-sans text-[3rem] leading-none font-bold text-[#ff8800] sm:text-[3.4rem] xl:text-[3.5rem]">&ldquo;&rdquo;</p>

                            <p class="mt-5 max-w-[46rem] text-[1rem] leading-[1.34] text-white/82 sm:text-[1.08rem] xl:text-[1.02rem] xl:leading-[1.22]">
                                {{ $founder['statement'] ?? '' }}
                            </p>
                        </div>

                        <div class="mt-7 xl:mt-9">
                            <h2 class="text-[1.45rem] leading-none font-semibold tracking-[-0.03em] text-[#ff8800] sm:text-[1.7rem] xl:text-[1.75rem]">
                                {{ $founderName }}
                            </h2>

                            <p class="mt-1 text-[1rem] leading-none text-white/86 sm:text-[1.05rem] xl:text-[1rem]">
                                {{ $founderRole }}
                            </p>
                        </div>
                    </article>
                </div>
            </div>
        </section>

        {{-- Difference --}}
        @include('frontend.partials.why-choose-us-section', [
            'difference' => $page['difference'] ?? [],
            'variant' => 'about',
        ])

        {{-- Media --}}
        @include('frontend.partials.media-section', [
            'media' => $page['media'] ?? [],
            'sectionId' => 'about-media',
        ])

        {{-- Portfolio --}}
        @include('frontend.partials.portfolio-section', [
            'portfolio' => data_get($site, 'pages.projects.portfolio', []),
            'isStandalone' => false,
        ])
    </div>
@endsection
