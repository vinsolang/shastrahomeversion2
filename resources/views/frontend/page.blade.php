@extends('layouts.marketing')

@section('title', 'Shastra | ' . $page['title'])
@section('meta_description', $page['description'])

@section('content')
    @php
        $cards = $page['cards'] ?? [];
        $difference = $page['difference'] ?? [];
        $media = $page['media'] ?? [];
        $portfolio = $page['portfolio'] ?? [];
    @endphp

    {{-- Hero --}}
    <section class="relative overflow-hidden bg-[#171717] text-white">
        <div class="relative mx-auto max-w-[1904px] overflow-hidden bg-[linear-gradient(135deg,#121212_0%,#1f1f1f_48%,#171717_100%)]">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,rgba(255,136,0,0.14),transparent_28%),radial-gradient(circle_at_70%_20%,rgba(255,255,255,0.06),transparent_22%)]"></div>

            <div class="relative z-10 flex min-h-[calc(100vh-62px)] items-center px-6 py-14 sm:px-8 lg:min-h-[calc(100vh-76px)] lg:px-16 lg:py-16 xl:px-[9.9375rem]">
                <div class="relative w-full max-w-[58rem]">
                    <div class="absolute left-0 top-0 h-24 w-3 bg-[#ff8800] sm:h-28"></div>

                    <div class="ml-3 bg-[linear-gradient(90deg,rgba(18,18,18,0.56)_0%,rgba(18,18,18,0.22)_70%,rgba(18,18,18,0.08)_100%)] px-6 py-8 shadow-[0_30px_70px_rgba(0,0,0,0.26)] backdrop-blur-[1.5px] sm:px-10 sm:py-10 lg:px-[4.5rem] lg:py-[4.1rem]" data-aos="fade-up" data-aos-duration="780">
                        <p class="text-[0.75rem] font-medium uppercase tracking-[0.42em] text-[#ff9808] sm:text-[0.875rem]">
                            {{ $page['eyebrow'] }}
                        </p>

                        <h1 class="mt-6 max-w-[44rem] font-display text-[3.1rem] leading-[0.92] font-extrabold tracking-[-0.06em] text-white sm:text-[4.25rem] lg:text-[5.25rem]">
                            {{ $page['title'] }}
                        </h1>

                        <p class="mt-5 max-w-[35rem] text-lg leading-[1.4] font-normal text-white/84 sm:text-[1.35rem] lg:text-[1.55rem]">
                            {{ $page['description'] }}
                        </p>

                        <div class="mt-8">
                            <a
                                href="{{ route('contact') }}"
                                class="inline-flex h-[4rem] items-center justify-center bg-[#ff9500] px-8 text-base font-semibold text-white transition hover:bg-[#ffa726]"
                            >
                                Contact Us
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Services --}}
    @if (! empty($cards))
        @include('frontend.partials.services-cards-section', [
            'cards' => $cards,
        ])
    @endif

    {{-- Difference --}}
    @if (! empty($difference))
        @include('frontend.partials.why-choose-us-section', [
            'difference' => $difference,
        ])
    @endif

    {{-- Media --}}
    @if (! empty($media))
        @include('frontend.partials.media-section', [
            'media' => $media,
        ])
    @endif

    {{-- Portfolio --}}
    @if (! empty($portfolio))
        @include('frontend.partials.portfolio-section', [
            'portfolio' => $portfolio,
            'isStandalone' => false,
        ])
    @endif
@endsection
