@extends('admin.layouts.app')
@section('header')
    <h1>Edit Why</h1>
@endsection
@section('content')
    <div class="max-w-7xl mx-auto shadow-md rounded-lg p-6 my-2">
        <h2 class="text-2xl font-bold text-[#401457]">Edit Why</h2>
        <form action="{{ route('why.update', $why->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PATCH')
            @component('admin.components.alert')
            @endcomponent

            <div class="grid grid-cols-1 gap-2">
                <div class="space-y-4">
                    <h1 class="text-[20px] font-[600] text-[#830B00] uppercase hidden">English</h1>

                    <div>
                        <label for="title_en" class="block text-sm font-medium text-[#000] mb-2">Title</label>
                        <input value="{{ old('title_en', $why->title_en) }}" name="title_en" id="title_en"
                            class="mt-1 block w-full p-2 border rounded-md text-black text-[12px]"></input>
                        <x-input-error class="mt-2" :messages="$errors->get('title_en')" />
                    </div>
                    <div>
                        <label for="content_en" class="block text-sm font-medium text-[#000] mb-2">Content</label>
                        <textarea name="content_en" id="content_en" rows="6"
                            class="mt-1 block w-full p-2 border rounded-md text-black text-[12px]">{{ old('content_en', $why->content_en) }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('content_en')" />
                    </div>

                </div>

            </div>

            <div class="hidden">
                <h1 class="text-[#401457]">Image</h1>
                <label for="dropzone-file{{ $why->id }}" id="drop-area"
                    class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6 w-full h-full bg-contain bg-center bg-no-repeat rounded-md text-center"
                        id="img-preview" style="background-image: url('{{ asset($why->image) }}')">
                        <p class="mb-2 text-[12px] sm:text-[14px] text-[#000]"><span class="font-semibold">Click
                                to
                                upload</span> or drag and drop</p>
                        <p class="text-xs text-[#000]">SVG, PNG, JPG or GIF (MAX. 5MB)</p>
                    </div>
                    <input id="dropzone-file{{ $why->id }}" type="file" class="hidden" name="image"
                        accept="image/*" onchange="uploadImage(event)" />
                </label>
                <x-input-error class="mt-2" :messages="$errors->get('image')" />
            </div>

            <div class="flex justify-between">
                <a href="{{ route('why.index') }}"
                    class="border border-[#1e1e1e] hover:!bg-[#1e1e1e] hover:!text-[#ffffff] px-4 py-1 md:px-6 rounded-[5px] text-[#1e1e1e]">
                    Back
                </a>

                <button type="submit" class="bg-[#1e1e1e] text-white px-4 py-1 md:px-6 rounded-[5px]">Submit</button>
            </div>
        </form>
    </div>

@endsection
@section('js')
    <script>
        ClassicEditor
            .create(document.querySelector('#content_en'), {
                toolbar: [
                    'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList',
                    'undo', 'redo', 'code', 'codeBlock'
                ],
                removePlugins: ['Heading']
            })
            .catch(error => {
                console.error(error);
            });

        function uploadImage(event) {
            const file = event.target.files[0];
            if (file) {
                const imgLink = URL.createObjectURL(file);
                const preview = document.getElementById('img-preview');
                preview.style.backgroundImage = `url(${imgLink})`;
                preview.style.backgroundSize = "contain";
                preview.style.backgroundPosition = "center";
                preview.innerHTML = "";
            }
        }

        // Drag and drop for image
        const imageDropArea = document.getElementById('drop-area-image');
        const imageInput = document.getElementById('dropzone-image');
        const imagePreview = document.getElementById('image-preview');

        imageDropArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            imageDropArea.classList.add('border-blue-500');
        });
        imageDropArea.addEventListener('dragleave', () => {
            imageDropArea.classList.remove('border-blue-500');
        });
        imageDropArea.addEventListener('drop', (e) => {
            e.preventDefault();
            imageDropArea.classList.remove('border-blue-500');
            const file = e.dataTransfer.files[0];
            if (file) {
                imageInput.files = e.dataTransfer.files;
                uploadImage({
                    target: {
                        files: [file]
                    }
                });
            }
        });
    </script>
@endsection
