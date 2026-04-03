@extends('admin.layouts.app')

@section('header')
    <h1>Edit Project</h1>
@endsection

@section('content')
    @php
        $existingImages = collect(old('old_images', $project_backend->images ?? []))
            ->filter(static fn ($img) => is_string($img) && $img !== '')
            ->values();
    @endphp

    <div class="max-w-7xl mx-auto shadow-md rounded-lg p-6 my-2">
        <h2 class="text-2xl font-bold text-[#613bf1] mb-4">Edit Project</h2>

        <form action="{{ route('project_backend.update', $project_backend->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            @component('admin.components.alert')
            @endcomponent

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label>Name</label>
                    <input
                        type="text"
                        name="name"
                        value="{{ old('name', $project_backend->name) }}"
                        class="w-full border p-2 rounded text-sm"
                        required
                    >
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                <div>
                    <label>Location</label>
                    <input
                        type="text"
                        name="location"
                        value="{{ old('location', $project_backend->location) }}"
                        class="w-full border p-2 rounded text-sm"
                        required
                    >
                    <x-input-error class="mt-2" :messages="$errors->get('location')" />
                </div>

                <div class="md:col-span-2">
                    <label>Description</label>
                    <textarea
                        name="desc"
                        rows="4"
                        id="desc"
                        class="w-full border p-2 rounded text-sm"
                    >{!! old('desc', $project_backend->desc) !!}</textarea>
                    <x-input-error class="mt-2" :messages="$errors->get('desc')" />
                </div>

                <div class="md:col-span-2">
                    <label>Specifications</label>
                    <textarea
                        name="specifications"
                        rows="4"
                        id="specifications"
                        class="w-full border p-2 rounded text-sm"
                    >{!! old('specifications', $project_backend->specifications) !!}</textarea>
                    <x-input-error class="mt-2" :messages="$errors->get('specifications')" />
                </div>
            </div>

            <div>
                <label class="font-semibold">Old Images</label>

                <div class="flex flex-wrap gap-3 mt-3">
                    @if ($existingImages->isNotEmpty())
                        @foreach ($existingImages as $img)
                            <div class="relative w-24 h-24 border rounded overflow-hidden">
                                <img src="{{ route('public.media.show', ['path' => $img]) }}" class="w-full h-full object-cover">

                                <button
                                    type="button"
                                    onclick="removeOldImage(this)"
                                    class="absolute top-0 right-0 bg-red-600 text-white w-5 h-5 rounded-full text-xs"
                                >
                                    &times;
                                </button>

                                <input type="hidden" name="old_images[]" value="{{ $img }}">
                            </div>
                        @endforeach
                    @else
                        <p class="text-gray-400 text-sm">No images</p>
                    @endif
                </div>
            </div>

            <div>
                <label class="font-semibold">Upload New Images</label>

                <input
                    type="file"
                    name="images[]"
                    multiple
                    accept="image/*"
                    class="block border rounded p-2 text-sm mt-2"
                    id="newImages"
                >
                <x-input-error class="mt-2" :messages="$errors->get('images')" />
                <x-input-error class="mt-2" :messages="$errors->get('images.*')" />

                <div id="previewNew" class="flex flex-wrap gap-3 mt-3 bg-gray-50 p-2 rounded min-h-[60px]">
                    <p class="text-gray-400 text-sm">No new images</p>
                </div>
            </div>

            <div>
                <label>Category</label>
                <select name="category_id" class="w-full border p-2 rounded text-sm" required>
                    <option value="">Select</option>
                    @foreach ($cats as $c)
                        <option value="{{ $c->id }}" {{ old('category_id', $project_backend->category_id) == $c->id ? 'selected' : '' }}>
                            {{ $c->name_en }}
                        </option>
                    @endforeach
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('category_id')" />
            </div>

            <div class="flex justify-between">
                <a href="{{ route('project_backend.index') }}" class="px-4 py-1 border rounded">Back</a>

                <button type="submit" class="bg-[#613bf1] text-white px-6 py-1 rounded">
                    Update
                </button>
            </div>
        </form>
    </div>
@endsection

@section('js')
    <script>
        const descField = document.querySelector('#desc');
        const specificationsField = document.querySelector('#specifications');
        const input = document.getElementById('newImages');
        const preview = document.getElementById('previewNew');
        const editorConfig = {
            toolbar: [
                'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList',
                'undo', 'redo', 'code', 'codeBlock'
            ],
            removePlugins: ['Heading']
        };

        if (window.ClassicEditor && descField) {
            ClassicEditor.create(descField, editorConfig).catch(error => {
                console.error(error);
            });
        }

        if (window.ClassicEditor && specificationsField) {
            ClassicEditor.create(specificationsField, editorConfig).catch(error => {
                console.error(error);
            });
        }

        if (input && preview) {
            input.addEventListener('change', () => {
                const files = Array.from(input.files ?? []);

                if (files.length === 0) {
                    preview.innerHTML = '<p class="text-gray-400 text-sm">No new images</p>';
                    return;
                }

                preview.innerHTML = '';

                files.forEach((file, index) => {
                    const url = URL.createObjectURL(file);

                    const div = document.createElement('div');
                    div.className = 'relative w-24 h-24 border rounded overflow-hidden';

                    const img = document.createElement('img');
                    img.src = url;
                    img.className = 'w-full h-full object-cover';

                    const btn = document.createElement('button');
                    btn.innerHTML = '&times;';
                    btn.type = 'button';
                    btn.className = 'absolute top-0 right-0 bg-red-600 text-white w-5 h-5 rounded-full text-xs';

                    btn.onclick = () => {
                        files.splice(index, 1);
                        updateFiles(input, files);
                        div.remove();

                        if (files.length === 0) {
                            preview.innerHTML = '<p class="text-gray-400 text-sm">No new images</p>';
                        }
                    };

                    div.appendChild(img);
                    div.appendChild(btn);
                    preview.appendChild(div);
                });
            });
        }

        function removeOldImage(button) {
            const wrapper = button.parentElement;
            wrapper.remove();
        }

        function updateFiles(input, files) {
            const dt = new DataTransfer();
            files.forEach(file => dt.items.add(file));
            input.files = dt.files;
        }
    </script>
@endsection
