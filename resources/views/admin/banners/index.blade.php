@extends('admin.layouts.app')

@section('header')
    <h1>Video Footage</h1>
@endsection

@section('content')
<div class="p-6">

    @foreach($banners as $banner)
        <div class="mb-6 border p-4">

            <h3>{{ $banner->name }}</h3>

            @if($banner->media)
                @if($banner->media['type'] === 'video')
                    <video controls width="300">
                        <source src="{{ asset($banner->media['path']) }}">
                    </video>
                @else
                    <img src="{{ asset($banner->media['path']) }}" width="300">
                @endif
            @endif

            <br><br>

            <a href="{{ route('banner.edit', $banner->id) }}" 
               class="bg-green-600 text-white px-4 py-2">
                Edit
            </a>

        </div>
    @endforeach

</div>
@endsection