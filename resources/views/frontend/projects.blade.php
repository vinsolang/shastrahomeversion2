@extends('layouts.marketing')

@section('title', 'Shastra | ' . $page['title'])
@section('meta_description', $page['description'])

    @section('content')
    <div class="bg-white text-[#1f1f1f]">
        {{-- Portfolio --}}
        @include('frontend.partials.portfolio-section', [
            'portfolio' => $page['portfolio'] ?? [],
            'isStandalone' => true,
        ])

        {{-- Difference --}}
        @if (! empty($page['difference'] ?? []))
            @include('frontend.partials.why-choose-us-section', [
                'difference' => $page['difference'],
            ])
        @endif

        {{-- Media --}}
        @if (! empty($page['media'] ?? []))
            @include('frontend.partials.media-section', [
                'media' => $page['media'],
            ])
        @endif
    </div>
@endsection
