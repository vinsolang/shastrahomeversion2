{{-- Services Page --}}
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
            'difference' => $differenceData,
            'variant' => 'services',
        ])

        {{-- Media --}}
        @include('frontend.partials.media-section', [
            'media' => $media,
        ])

        {{-- Portfolio — rendered identically to the standalone Projects page --}}
        @include('frontend.partials.portfolio-section', [
            'portfolio'    => data_get($site, 'pages.projects.portfolio', []),
            'isStandalone' => true,
        ])
    </div>
@endsection