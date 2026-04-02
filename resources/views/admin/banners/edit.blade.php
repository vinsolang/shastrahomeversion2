@extends('admin.layouts.app')

@section('header')
    <h1>Edit Video Footage</h1>
@endsection

@section('content')
<div class="max-w-4xl mx-auto mt-10">

    <form action="{{ route('banner.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <input type="text" name="name" value="{{ $banner->name }}" class="mb-4 border p-2 w-full">

        <input type="file" name="media" id="mediaInput" class="mb-4">

        <div id="preview" class="border p-4">

            @if($banner->media)
                @if($banner->media['type'] === 'video')
                    <video controls class="w-full">
                        <source src="{{ asset($banner->media['path']) }}" type="{{ $banner->media['mime'] ?? 'video/mp4' }}">
                    </video>
                @else
                    <img src="{{ asset($banner->media['path']) }}" class="w-full">
                @endif
            @endif

        </div>

        <button type="submit" class="mt-4 bg-blue-600 text-white px-6 py-2">
            Update
        </button>
    </form>

</div>
@endsection

@section('js')
<script>
document.getElementById('mediaInput').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (!file) return;

    const preview = document.getElementById('preview');
    preview.innerHTML = '';

    const url = URL.createObjectURL(file);

    if (file.type.startsWith('video/')) {
        preview.innerHTML = `<video controls class="w-full"><source src="${url}"></video>`;
    } else {
        preview.innerHTML = `<img src="${url}" class="w-full">`;
    }
});
</script>
@endsection