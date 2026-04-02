@extends('admin.layouts.app')
@section('header')
    <h1>Create About</h1>
@endsection
@section('content')
    <div class="max-w-7xl mx-auto shadow-md rounded-lg p-6 my-2">
        <h2 class="text-2xl font-bold text-[#1e1e1e]">Create About</h2>
        <form action="{{ route('about.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @component('admin.components.alert')
            @endcomponent


            <div class="grid grid-cols-1 gap-2">
                <div class="space-y-4">
                    <h1 class="text-[20px] font-[600] text-[#830B00] uppercase">English</h1>
                    <div>
                        <label for="title_en" class="block text-sm font-medium text-[#000] mb-2">Title</label>
                        <input value="{{ old('title_en') }}" name="title_en" id="title_en"
                            class="mt-1 block w-full p-2 border rounded-md text-black text-[12px]"></input>
                        <x-input-error class="mt-2" :messages="$errors->get('title_en')" />
                    </div>
                    <div>
                        <label for="content1_en" class="block text-sm font-medium text-[#000] mb-2">Content 1</label>
                        <textarea name="content1_en" id="content1_en" rows="6"
                            class="mt-1 block w-full p-2 border rounded-md text-black text-[12px]"></textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('content1_en')" />
                    </div>
                    <div>
                        <label for="content2_en" class="block text-sm font-medium text-[#000] mb-2">Content 2</label>
                        <textarea name="content2_en" id="content2_en" rows="4"
                            class="mt-1 block w-full p-2 border rounded-md text-black text-[12px]"></textarea>
                        <p class="mt-1 text-[11px] text-gray-500">Optional secondary line. Use this for founder roles such as "Founder".</p>
                        <x-input-error class="mt-2" :messages="$errors->get('content2_en')" />
                    </div>
                    <div>
                        <label for="content3_en" class="block text-sm font-medium text-[#000] mb-2">Content 3</label>
                        <textarea name="content3_en" id="content3_en" rows="4"
                            class="mt-1 block w-full p-2 border rounded-md text-black text-[12px]"></textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('content3_en')" />
                    </div>
                    <div>
                        <label for="content4_en" class="block text-sm font-medium text-[#000] mb-2">Content 4</label>
                        <textarea name="content4_en" id="content4_en" rows="4"
                            class="mt-1 block w-full p-2 border rounded-md text-black text-[12px]"></textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('content4_en')" />
                    </div>
                    <div>
                        <label for="content5_en" class="block text-sm font-medium text-[#000] mb-2">Content 5</label>
                        <textarea name="content5_en" id="content5_en" rows="4"
                            class="mt-1 block w-full p-2 border rounded-md text-black text-[12px]"></textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('content5_en')" />
                    </div>
                    <div>
                        <label for="image_file" class="block text-sm font-medium text-[#000] mb-2">Image File</label>
                        <input type="file" name="image_file" id="image_file" accept="image/*"
                            class="mt-1 block w-full rounded-md border border-gray-300 bg-white p-2 text-[12px] text-black">
                        <p class="mt-1 text-[11px] text-gray-500">Optional. Use this for visual sections such as the founder card.</p>
                        <x-input-error class="mt-2" :messages="$errors->get('image_file')" />
                    </div>
                    <div>
                        <label for="pdf_file" class="block text-sm font-medium text-[#000] mb-2">PDF File</label>
                        <input type="file" name="pdf_file" id="pdf_file" accept="application/pdf"
                            class="mt-1 block w-full rounded-md border border-gray-300 bg-white p-2 text-[12px] text-black">
                        <p class="mt-1 text-[11px] text-gray-500">Optional. Upload a PDF brochure or supporting document.</p>
                        <x-input-error class="mt-2" :messages="$errors->get('pdf_file')" />
                    </div>
                </div>

                <div class="space-y-4 hidden">
                    <h1 class="text-[20px] font-[600] text-[#830B00] uppercase">Khmer</h1>
                    <div>
                        <label for="title_km" class="block text-sm font-medium text-[#000] mb-2">Title</label>
                        <input value="{{ old('title_km') }}" name="title_km" id="title_km"
                            class="mt-1 block w-full p-2 border rounded-md text-black text-[12px]"></input>
                        <x-input-error class="mt-2" :messages="$errors->get('title_km')" />
                    </div>
                    <div>
                        <label for="content1_km" class="block text-sm font-medium text-[#000] mb-2">Content 1</label>
                        <textarea name="content1_km" id="content1_km" rows="6"
                            class="mt-1 block w-full p-2 border rounded-md text-black text-[12px]"></textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('content1_km')" />
                    </div>
                    <div>
                        <label for="content2_km" class="block text-sm font-medium text-[#000] mb-2">Content 2</label>
                        <textarea name="content2_km" id="content2_km" rows="6"
                            class="mt-1 block w-full p-2 border rounded-md text-black text-[12px]"></textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('content2_km')" />
                    </div>
                    <div>
                        <label for="content3_km" class="block text-sm font-medium text-[#000] mb-2">Content 3</label>
                        <textarea name="content3_km" id="content3_km" rows="6"
                            class="mt-1 block w-full p-2 border rounded-md text-black text-[12px]"></textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('content3_km')" />
                    </div>
                    <div>
                        <label for="content4_km" class="block text-sm font-medium text-[#000] mb-2">Content 4</label>
                        <textarea name="content4_km" id="content4_km" rows="6"
                            class="mt-1 block w-full p-2 border rounded-md text-black text-[12px]"></textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('content4_km')" />
                    </div>
                    <div>
                        <label for="content5_km" class="block text-sm font-medium text-[#000] mb-2">Content 5</label>
                        <textarea name="content5_km" id="content5_km" rows="6"
                            class="mt-1 block w-full p-2 border rounded-md text-black text-[12px]"></textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('content5_km')" />
                    </div>
                </div>

                <div class="space-y-4 hidden">
                    <h1 class="text-[20px] font-[600] text-[#830B00] uppercase">Chinese</h1>
                    <div>
                        <label for="title_ch" class="block text-sm font-medium text-[#000] mb-2">Title</label>
                        <input value="{{ old('title_ch') }}" name="title_ch" id="title_ch"
                            class="mt-1 block w-full p-2 border rounded-md text-black text-[12px]"></input>
                        <x-input-error class="mt-2" :messages="$errors->get('title_ch')" />
                    </div>
                    <div>
                        <label for="content1_ch" class="block text-sm font-medium text-[#000] mb-2">Content 1</label>
                        <textarea name="content1_ch" id="content1_ch" rows="6"
                            class="mt-1 block w-full p-2 border rounded-md text-black text-[12px]"></textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('content1_ch')" />
                    </div>
                    <div>
                        <label for="content2_ch" class="block text-sm font-medium text-[#000] mb-2">Content 2</label>
                        <textarea name="content2_ch" id="content2_ch" rows="6"
                            class="mt-1 block w-full p-2 border rounded-md text-black text-[12px]"></textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('content2_ch')" />
                    </div>
                    <div>
                        <label for="content3_ch" class="block text-sm font-medium text-[#000] mb-2">Content 3</label>
                        <textarea name="content3_ch" id="content3_ch" rows="6"
                            class="mt-1 block w-full p-2 border rounded-md text-black text-[12px]"></textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('content3_ch')" />
                    </div>
                    <div>
                        <label for="content4_ch" class="block text-sm font-medium text-[#000] mb-2">Content 4</label>
                        <textarea name="content4_ch" id="content4_ch" rows="6"
                            class="mt-1 block w-full p-2 border rounded-md text-black text-[12px]"></textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('content4_ch')" />
                    </div>
                    <div>
                        <label for="content5_ch" class="block text-sm font-medium text-[#000] mb-2">Content 5</label>
                        <textarea name="content5_ch" id="content5_ch" rows="6"
                            class="mt-1 block w-full p-2 border rounded-md text-black text-[12px]"></textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('content5_ch')" />
                    </div>
                </div>
            </div>

            <div class="flex justify-between">
                <a href="{{ route('about.index') }}"
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
    </script>
@endsection
