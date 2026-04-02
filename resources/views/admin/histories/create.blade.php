@extends('admin.layouts.app')
@section('header')
    <h1>Create History</h1>
@endsection
@section('content')
    <div class="max-w-7xl mx-auto shadow-md rounded-lg p-6 my-2">
        <h2 class="text-2xl font-bold text-[#1e1e1e]">Create History</h2>
        <form action="{{ route('history.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @component('admin.components.alert')
            @endcomponent

            <div>
                <label for="year" class="block text-sm font-medium text-[#000] mb-2">Year</label>
                <input value="{{ old('year') }}" name="year" id="year"
                    class="mt-1 block w-full p-2 border rounded-md text-black text-[12px]"></input>
                <x-input-error class="mt-2" :messages="$errors->get('year')" />
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                <div class="space-y-4">
                    <h1 class="text-[20px] font-[600] text-[#830B00] uppercase">English</h1>
                    <div>
                        <label for="content_en" class="block text-sm font-medium text-[#000] mb-2">Content
                            (English)</label>
                        <textarea name="content_en" id="content_en" rows="6"
                            class="mt-1 block w-full p-2 border rounded-md text-black text-[12px]"></textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('content_en')" />
                    </div>
                </div>

                <div class="space-y-4">
                    <h1 class="text-[20px] font-[600] text-[#830B00] uppercase">Khmer</h1>
                    <div>
                        <label for="content_km" class="block text-sm font-medium text-[#000] mb-2">Content
                            (Khmer)</label>
                        <textarea name="content_km" id="content_km" rows="6"
                            class="mt-1 block w-full p-2 border rounded-md text-black text-[12px]"></textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('content_km')" />
                    </div>
                </div>

                <div class="space-y-4">
                    <h1 class="text-[20px] font-[600] text-[#830B00] uppercase">Chinese</h1>
                    <div>
                        <label for="content_ch" class="block text-sm font-medium text-[#000] mb-2">Content
                            (Chinese)</label>
                        <textarea name="content_ch" id="content_ch" rows="6"
                            class="mt-1 block w-full p-2 border rounded-md text-black text-[12px]"></textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('content_ch')" />
                    </div>
                </div>
            </div>


            {{-- <div>
                <label for="dropzone-file" id="drop-area"
                    class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6 w-full h-full bg-contain bg-center bg-no-repeat rounded-md text-center"
                        id="img-preview">
                        <svg class="w-8 h-8 mb-4 text-[#000]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 20 16">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                        </svg>
                        <p class="mb-2 text-[12px] sm:text-[14px] text-[#000]"><span class="font-semibold">Click to
                                upload</span> or drag and drop</p>
                        <p class="text-xs text-[#000]">SVG, PNG, JPG or GIF (MAX. 5MB)</p>
                    </div>
                    <input id="dropzone-file" type="file" class="hidden" name="image" accept="image/*"
                        onchange="uploadImage(event)" />
                </label>
                <x-input-error class="mt-2" :messages="$errors->get('image')" />
            </div> --}}
            <div>
                <label for="dropzone-file" id="drop-area"
                    class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50">

                    <input id="dropzone-file" type="file" class="hidden" name="images[]" accept="image/*" multiple
                        onchange="uploadImages(event)" />
                </label>
                <x-input-error class="mt-2" :messages="$errors->get('image')" />
            </div>

            <div id="img-preview"
                class="flex flex-wrap gap-2 justify-center items-center w-full h-full bg-gray-50 rounded-md overflow-y-auto p-4">
                <p class="text-gray-400 text-sm">No images selected.</p>
            </div>

            <div class="flex justify-between">
                <a href="{{ route('history.index') }}"
                    class="border border-[#4FC9EE] hover:!bg-[#4FC9EE] hover:!text-[#ffffff] px-4 py-1 md:px-6 rounded-[5px] text-[#4FC9EE]">
                    Back
                </a>

                <button type="submit" class="bg-[#4FC9EE] text-white px-4 py-1 md:px-6 rounded-[5px]">Submit</button>
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

        ClassicEditor
            .create(document.querySelector('#content_km'), {
                toolbar: [
                    'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList',
                    'undo', 'redo', 'code', 'codeBlock'
                ],
                removePlugins: ['Heading']
            })
            .catch(error => {
                console.error(error);
            });

        ClassicEditor
            .create(document.querySelector('#content_ch'), {
                toolbar: [
                    'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList',
                    'undo', 'redo', 'code', 'codeBlock'
                ],
                removePlugins: ['Heading']
            })
            .catch(error => {
                console.error(error);
            });

        const dropArea = document.getElementById('drop-area');
        const imageFileInput = document.getElementById('dropzone-file');
        const imagePreview = document.getElementById('img-preview');
        let selectedFiles = [];

        function uploadImages(event) {
            const files = Array.from(event.target.files);
            selectedFiles.push(...files);
            renderImagePreviews();
            syncInputFiles();
        }

        function renderImagePreviews() {
            imagePreview.innerHTML = '';

            if (selectedFiles.length === 0) {
                imagePreview.innerHTML = '<p class="text-gray-400 text-sm">No images selected.</p>';
                return;
            }

            selectedFiles.forEach((file, index) => {
                const imgLink = URL.createObjectURL(file);
                const wrapper = document.createElement('div');
                wrapper.className = 'relative draggable';
                wrapper.dataset.index = index;

                const img = document.createElement('img');
                img.src = imgLink;
                img.className = 'w-24 h-24 object-contain rounded border p-1';

                const removeBtn = document.createElement('button');
                removeBtn.textContent = '✕';
                removeBtn.className =
                    'absolute top-0 right-0 bg-red-600 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs';
                removeBtn.type = 'button';
                removeBtn.onclick = () => {
                    selectedFiles.splice(index, 1);
                    renderImagePreviews();
                    syncInputFiles();
                };

                wrapper.appendChild(img);
                wrapper.appendChild(removeBtn);
                imagePreview.appendChild(wrapper);
            });

            initSortable(); // Reinitialize Sortable after DOM update
        }

        function syncInputFiles() {
            const dataTransfer = new DataTransfer();
            selectedFiles.forEach(file => {
                dataTransfer.items.add(file);
            });
            imageFileInput.files = dataTransfer.files;
        }

        // Drag-and-drop input
        dropArea.addEventListener('dragover', (event) => {
            event.preventDefault();
            dropArea.classList.add('border-blue-500');
        });

        dropArea.addEventListener('dragleave', () => {
            dropArea.classList.remove('border-blue-500');
        });

        dropArea.addEventListener('drop', (event) => {
            event.preventDefault();
            dropArea.classList.remove('border-blue-500');

            const files = Array.from(event.dataTransfer.files);
            selectedFiles.push(...files);
            renderImagePreviews();
            syncInputFiles();
        });

        imageFileInput.addEventListener('click', () => {
            imageFileInput.value = null;
        });
    </script>
@endsection
