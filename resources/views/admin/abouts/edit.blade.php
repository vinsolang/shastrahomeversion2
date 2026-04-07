@extends('admin.layouts.app')
@section('header')
    <h1>Edit About</h1>
@endsection
@section('content')
    @php
        $isFounderSection = $about->section_key === 'founder';
        $isCoreValuesSection = $about->section_key === 'core-values';
        $isCompanyProfileSection = $about->section_key === 'company-profile';
        $imageUrl = filled($about->image_path)
            ? (filter_var($about->image_path, FILTER_VALIDATE_URL) ? $about->image_path : route('public.media.show', ['path' => $about->image_path]))
            : null;
    @endphp

    <div class="max-w-7xl mx-auto shadow-md rounded-lg p-6 my-2">
        <h2 class="text-2xl font-bold text-[#401457]">Edit About</h2>
        <form action="{{ route('about.update', $about->id) }}" method="POST" enctype="multipart/form-data"
            class="space-y-4">
            @csrf
            @method('PATCH')
            @component('admin.components.alert')
            @endcomponent

            @if ($isFounderSection)
                <div class="rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-[12px] text-amber-900">
                    This record powers the founder section on the public about page. Use the title for the founder name,
                    Content 1 for the message, Content 2 for the role, and the image upload for the portrait.
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                <div class="space-y-4">
                    <h1 class="text-[20px] font-[600] text-[#830B00] uppercase">English</h1>

                    <div>
                        <label for="title_en" class="block text-sm font-medium text-[#000] mb-2">
                            {{ $isFounderSection ? 'Founder Name' : 'Title' }}
                        </label>
                        <input value="{{ old('title_en', $about->title_en) }}" name="title_en" id="title_en"
                            class="mt-1 block w-full p-2 border rounded-md text-black text-[12px]"></input>
                        <x-input-error class="mt-2" :messages="$errors->get('title_en')" />
                    </div>
                    <div>
                        <label for="content1_en" class="block text-sm font-medium text-[#000] mb-2">
                            {{ $isFounderSection ? 'Founder Message' : 'Content 1' }}
                        </label>
                        <textarea name="content1_en" id="content1_en" rows="6"
                            class="mt-1 block w-full p-2 border rounded-md text-black text-[12px]">{{ old('content1_en', $about->content1_en) }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('content1_en')" />
                    </div>

                    @if ($isFounderSection || $isCoreValuesSection)
                        <div>
                            <label for="content2_en" class="block text-sm font-medium text-[#000] mb-2">
                                {{ $isFounderSection ? 'Founder Role' : 'Content 2' }}
                            </label>
                            <textarea name="content2_en" id="content2_en" rows="6"
                                class="mt-1 block w-full p-2 border rounded-md text-black text-[12px]">{{ old('content2_en', $about->content2_en) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('content2_en')" />
                        </div>
                    @endif

                    @if ($isCoreValuesSection)
                        <div>
                            <label for="content3_en" class="block text-sm font-medium text-[#000] mb-2">Content 3</label>
                            <textarea name="content3_en" id="content3_en" rows="6"
                                class="mt-1 block w-full p-2 border rounded-md text-black text-[12px]">{{ old('content3_en', $about->content3_en) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('content3_en')" />
                        </div>
                        <div>
                            <label for="content4_en" class="block text-sm font-medium text-[#000] mb-2">Content 4</label>
                            <textarea name="content4_en" id="content4_en" rows="6"
                                class="mt-1 block w-full p-2 border rounded-md text-black text-[12px]">{{ old('content4_en', $about->content4_en) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('content4_en')" />
                        </div>
                        <div>
                            <label for="content5_en" class="block text-sm font-medium text-[#000] mb-2">Content 5</label>
                            <textarea name="content5_en" id="content5_en" rows="6"
                                class="mt-1 block w-full p-2 border rounded-md text-black text-[12px]">{{ old('content5_en', $about->content5_en) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('content5_en')" />
                        </div>
                    @endif

                    @if ($isFounderSection)
                        <div>
                            <label for="image_file" class="block text-sm font-medium text-[#000] mb-2">Founder Image</label>
                            <input type="file" name="image_file" id="image_file" accept="image/*"
                                class="mt-1 block w-full rounded-md border border-gray-300 bg-white p-2 text-[12px] text-black"
                                onchange="previewAboutImage(event)">
                            <div id="image_preview_container" class="mt-3 {{ $imageUrl ? '' : 'hidden' }}">
                                <img id="image_preview" src="{{ $imageUrl ?? '#' }}" alt="{{ $about->title_en ?? 'Preview' }}"
                                    class="h-40 w-32 rounded-lg border border-gray-200 object-cover">
                            </div>
                            <p class="mt-1 text-[11px] text-gray-500">Optional. Upload a new portrait to replace the current founder image.</p>
                            <x-input-error class="mt-2" :messages="$errors->get('image_file')" />
                        </div>
                    @endif

                    @if ($isCompanyProfileSection)
                        <div>
                            <label for="pdf_file" class="block text-sm font-medium text-[#000] mb-2">Company Profile PDF File</label>
                            <input type="file" name="pdf_file" id="pdf_file" accept="application/pdf"
                                class="mt-1 block w-full rounded-md border border-gray-300 bg-white p-2 text-[12px] text-black">
                            @if ($about->pdf_path)
                                <a href="{{ route('public.media.show', ['path' => $about->pdf_path]) }}" target="_blank" rel="noopener"
                                    class="mt-2 inline-flex items-center gap-2 text-[12px] font-medium text-[#613bf1] hover:underline">
                                    <span>Open current PDF</span>
                                </a>
                            @endif
                            <p class="mt-1 text-[11px] text-gray-500">Optional. Upload a new PDF to replace the current file for the 'Download Company Profile' button.</p>
                            <x-input-error class="mt-2" :messages="$errors->get('pdf_file')" />
                        </div>
                    @endif
                </div>

                <div class="space-y-4 hidden">
                    <h1 class="text-[20px] font-[600] text-[#830B00] uppercase">Khmer</h1>
                    <div>
                        <label for="title_km" class="block text-sm font-medium text-[#000] mb-2">Title</label>
                        <input value="{{ old('title_km', $about->title_km) }}" name="title_km" id="title_km"
                            class="mt-1 block w-full p-2 border rounded-md text-black text-[12px]"></input>
                        <x-input-error class="mt-2" :messages="$errors->get('title_km')" />
                    </div>
                    <div>
                        <label for="content1_km" class="block text-sm font-medium text-[#000] mb-2">Content 1</label>
                        <textarea name="content1_km" id="content1_km" rows="6"
                            class="mt-1 block w-full p-2 border rounded-md text-black text-[12px]">{{ old('content1_km', $about->content1_km) }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('content1_km')" />
                    </div>
                    @if ($isFounderSection || $isCoreValuesSection)
                        <div>
                            <label for="content2_km" class="block text-sm font-medium text-[#000] mb-2">Content 2</label>
                            <textarea name="content2_km" id="content2_km" rows="6"
                                class="mt-1 block w-full p-2 border rounded-md text-black text-[12px]">{{ old('content2_km', $about->content2_km) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('content2_km')" />
                        </div>
                    @endif
                    @if ($isCoreValuesSection)
                        <div>
                            <label for="content3_km" class="block text-sm font-medium text-[#000] mb-2">Content 3</label>
                            <textarea name="content3_km" id="content3_km" rows="6"
                                class="mt-1 block w-full p-2 border rounded-md text-black text-[12px]">{{ old('content3_km', $about->content3_km) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('content3_km')" />
                        </div>
                        <div>
                            <label for="content4_km" class="block text-sm font-medium text-[#000] mb-2">Content 4</label>
                            <textarea name="content4_km" id="content4_km" rows="6"
                                class="mt-1 block w-full p-2 border rounded-md text-black text-[12px]">{{ old('content4_km', $about->content4_km) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('content4_km')" />
                        </div>
                        <div>
                            <label for="content5_km" class="block text-sm font-medium text-[#000] mb-2">Content 5</label>
                            <textarea name="content5_km" id="content5_km" rows="6"
                                class="mt-1 block w-full p-2 border rounded-md text-black text-[12px]">{{ old('content5_km', $about->content5_km) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('content5_km')" />
                        </div>
                    @endif
                </div>

                <div class="space-y-4 hidden">
                    <h1 class="text-[20px] font-[600] text-[#830B00] uppercase">Chinese</h1>
                    <div>
                        <label for="title_ch" class="block text-sm font-medium text-[#000] mb-2">Title</label>
                        <input value="{{ old('title_ch', $about->title_ch) }}" name="title_ch" id="title_ch"
                            class="mt-1 block w-full p-2 border rounded-md text-black text-[12px]"></input>
                        <x-input-error class="mt-2" :messages="$errors->get('title_ch')" />
                    </div>
                    <div>
                        <label for="content1_ch" class="block text-sm font-medium text-[#000] mb-2">Content 1</label>
                        <textarea name="content1_ch" id="content1_ch" rows="6"
                            class="mt-1 block w-full p-2 border rounded-md text-black text-[12px]">{{ old('content1_ch', $about->content1_ch) }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('content1_ch')" />
                    </div>
                    @if ($isFounderSection || $isCoreValuesSection)
                        <div>
                            <label for="content2_ch" class="block text-sm font-medium text-[#000] mb-2">Content 2</label>
                            <textarea name="content2_ch" id="content2_ch" rows="6"
                                class="mt-1 block w-full p-2 border rounded-md text-black text-[12px]">{{ old('content2_ch', $about->content2_ch) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('content2_ch')" />
                        </div>
                    @endif
                    @if ($isCoreValuesSection)
                        <div>
                            <label for="content3_ch" class="block text-sm font-medium text-[#000] mb-2">Content 3</label>
                            <textarea name="content3_ch" id="content3_ch" rows="6"
                                class="mt-1 block w-full p-2 border rounded-md text-black text-[12px]">{{ old('content3_ch', $about->content3_ch) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('content3_ch')" />
                        </div>
                        <div>
                            <label for="content4_ch" class="block text-sm font-medium text-[#000] mb-2">Content 4</label>
                            <textarea name="content4_ch" id="content4_ch" rows="6"
                                class="mt-1 block w-full p-2 border rounded-md text-black text-[12px]">{{ old('content4_ch', $about->content4_ch) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('content4_ch')" />
                        </div>
                        <div>
                            <label for="content5_ch" class="block text-sm font-medium text-[#000] mb-2">Content 5</label>
                            <textarea name="content5_ch" id="content5_ch" rows="6"
                                class="mt-1 block w-full p-2 border rounded-md text-black text-[12px]">{{ old('content5_ch', $about->content5_ch) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('content5_ch')" />
                        </div>
                    @endif
                </div>
            </div>

            <div class="flex justify-between">
                <a href="{{ route('about.index') }}"
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
        const editorToolbar = [
            'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|', 'undo', 'redo'
        ];

        [
            '#content1_en', '#content2_en', '#content3_en', '#content4_en', '#content5_en',
            '#content1_km', '#content2_km', '#content3_km', '#content4_km', '#content5_km',
            '#content1_ch', '#content2_ch', '#content3_ch', '#content4_ch', '#content5_ch'
        ].forEach((selector) => {
            const element = document.querySelector(selector);

            if (!element) {
                return;
            }

            ClassicEditor
                .create(element, {
                    toolbar: editorToolbar
                })
                .catch((error) => {
                    console.error(error);
                });
        });

        function previewAboutImage(event) {
            const input = event.target;
            const previewContainer = document.getElementById('image_preview_container');
            const previewImg = document.getElementById('image_preview');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    previewContainer.classList.remove('hidden');
                }

                reader.readAsDataURL(input.files[0]);
            } else {
                previewImg.src = '#';
                previewContainer.classList.add('hidden');
            }
        }
    </script>

    <script>
        const pdfInput = document.getElementById('pdf_file');
if (pdfInput) {
    pdfInput.addEventListener('change', function () {
        const file = this.files[0];
        if (file && file.size > 30 * 1024 * 1024) {
            alert('File is too large. Max size is 30MB.');
            this.value = '';
        }
    });
}
    </script>
@endsection
