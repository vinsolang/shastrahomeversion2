@extends('admin.layouts.app')

@section('header')
    <h1>Create Project</h1>
@endsection

@section('content')
    <div class="max-w-7xl mx-auto shadow-md rounded-lg p-6 my-2">
        <h2 class="text-2xl font-bold text-[#1e1e1e] mb-4">Create Project</h2>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc pl-5 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('project_backend.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @component('admin.components.alert')
            @endcomponent

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-10">
                    <div>
                        <label for="name" class="block text-sm font-medium text-[#000] mb-2">Name Project</label>
                        <input
                            value="{{ old('name') }}"
                            name="name"
                            id="name"
                            class="mt-1 block w-full p-2 border rounded-md text-black text-[12px]"
                            required
                        />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>

                    <div>
                        <label for="desc" class="block text-sm font-medium text-[#000] mb-2">Description</label>
                        <textarea
                            name="desc"
                            id="desc"
                            rows="6"
                            class="mt-1 block w-full p-2 border rounded-md text-black text-[12px]"
                        >{{ old('desc') }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('desc')" />
                    </div>
                </div>

                <div class="space-y-4">
                    <div>
                        <label for="location" class="block text-sm font-medium text-[#000] mb-2">Location</label>
                        <textarea
                            name="location"
                            id="location"
                            rows="2"
                            class="mt-1 block w-full p-2 border rounded-md text-black text-[12px]"
                            required
                        >{{ old('location') }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('location')" />
                    </div>

                    <div>
                        <label for="specifications" class="block text-sm font-medium text-[#000] mb-2">
                            Type Specifications
                        </label>
                        <textarea
                            name="specifications"
                            id="specifications"
                            rows="6"
                            class="mt-1 block w-full p-2 border rounded-md text-black text-[12px]"
                        >{{ old('specifications') }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('specifications')" />
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-[#000]">Image Project</label>

                <input
                    type="file"
                    name="images[]"
                    multiple
                    accept="image/*"
                    class="block border rounded p-1 text-sm"
                    id="projectImages"
                    required
                >

                <div id="color-preview" class="flex flex-wrap gap-2 mt-3 bg-gray-50 p-2 rounded-md min-h-[50px]">
                    <p class="text-gray-400 text-sm">No images selected.</p>
                </div>

                <x-input-error class="mt-2" :messages="$errors->get('images')" />
                <x-input-error class="mt-2" :messages="collect($errors->get('images.*'))->flatten()->all()" />
            </div>

            <div>
                <label for="category_id" class="block text-sm font-medium text-gray-700">Product Category</label>
                <select
                    class="w-full rounded-md mt-1 focus:ring-[#1e1e1e] focus:border-[#1e1e1e] text-sm text-[#1e1e1e]"
                    name="category_id"
                    id="category_id"
                    required
                >
                    <option value="">Select One</option>
                    @foreach ($cats as $c)
                        <option value="{{ $c->id }}" {{ old('category_id') == $c->id ? 'selected' : '' }}>
                            {{ $c->name_en }}
                        </option>
                    @endforeach
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('category_id')" />
            </div>

            <div class="flex justify-between mt-6">
                <a
                    href="{{ route('project_backend.index') }}"
                    class="border border-[#613bf1] hover:bg-[#613bf1] hover:text-white px-6 py-1 rounded"
                >
                    Back
                </a>
                <button type="submit" class="bg-[#613bf1] text-white px-6 py-1 rounded">Submit</button>
            </div>
        </form>
    </div>
@endsection

@section('js')
    <script>
        window.addEventListener('load', () => {
            const descField = document.querySelector('#desc');
            const specificationsField = document.querySelector('#specifications');
            const input = document.getElementById('projectImages');
            const preview = document.getElementById('color-preview');

            if (window.ClassicEditor && descField) {
                ClassicEditor.create(descField, {
                    toolbar: [
                        'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList',
                        'undo', 'redo', 'code', 'codeBlock'
                    ],
                    removePlugins: ['Heading']
                }).catch(error => {
                    console.error(error);
                });
            }

            if (window.ClassicEditor && specificationsField) {
                ClassicEditor.create(specificationsField, {
                    toolbar: [
                        'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList',
                        'undo', 'redo', 'code', 'codeBlock'
                    ],
                    removePlugins: ['Heading']
                }).catch(error => {
                    console.error(error);
                });
            }

            if (!input || !preview) {
                return;
            }

            input.addEventListener('change', () => {
                const files = Array.from(input.files ?? []);

                if (files.length === 0) {
                    preview.innerHTML = '<p class="text-gray-400 text-sm">No images selected.</p>';
                    return;
                }

                preview.innerHTML = '';

                files.forEach((file, index) => {
                    const imgURL = URL.createObjectURL(file);

                    const wrapper = document.createElement('div');
                    wrapper.className = 'relative w-24 h-24 border rounded overflow-hidden';

                    const img = document.createElement('img');
                    img.src = imgURL;
                    img.className = 'w-full h-full object-cover';

                    const btn = document.createElement('button');
                    btn.type = 'button';
                    btn.innerHTML = '&times;';
                    btn.className = 'absolute top-0 right-0 bg-red-600 text-white w-5 h-5 rounded-full text-xs flex items-center justify-center';

                    btn.onclick = () => {
                        files.splice(index, 1);
                        updateFiles(input, files);
                        wrapper.remove();

                        if (files.length === 0) {
                            preview.innerHTML = '<p class="text-gray-400 text-sm">No images selected.</p>';
                        }
                    };

                    wrapper.appendChild(img);
                    wrapper.appendChild(btn);
                    preview.appendChild(wrapper);
                });
            });
        });

        function updateFiles(input, files) {
            const dt = new DataTransfer();
            files.forEach(file => dt.items.add(file));
            input.files = dt.files;
        }
    </script>
@endsection
