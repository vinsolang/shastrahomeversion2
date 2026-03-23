@extends('layouts.marketing')

@section('title', 'Shastra | ' . $page['title'])
@section('meta_description', $page['description'])

    @section('content')
    @php
        $cards = $page['cards'] ?? [];
    @endphp

    <div class="bg-white text-[#1f1f1f]">
        {{-- Services --}}
        @include('frontend.partials.services-cards-section', [
            'cards' => $cards,
        ])

        {{-- Difference --}}
        @include('frontend.partials.why-choose-us-section', [
            'difference' => $page['difference'] ?? [],
            'variant' => 'services',
        ])

        {{-- Media --}}
        @include('frontend.partials.media-section', [
            'media' => $page['media'] ?? [],
        ])

        {{-- Portfolio --}}
        @include('frontend.partials.portfolio-section', [
            'portfolio' => data_get($site, 'pages.projects.portfolio', []),
            'isStandalone' => false,
        ])
    </div>
@endsection
