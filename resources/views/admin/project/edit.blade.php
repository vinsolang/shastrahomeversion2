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
                                <img src="{{ asset('storage/' . $img) }}" class="w-full h-full object-cover">

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

                {{-- size alert and progress bar injected here --}}
                <div id="image-alert-area"></div>

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
    /* ─── Image compression + alert helper ─── */
    async function compressImage(file, { maxWidth = 1920, maxHeight = 1080, quality = 0.82 } = {}) {
        return new Promise((resolve) => {
            const reader = new FileReader();
            reader.onload = (e) => {
                const img = new Image();
                img.onload = () => {
                    let { width, height } = img;
                    const ratio = Math.min(maxWidth / width, maxHeight / height, 1);
                    width  = Math.round(width  * ratio);
                    height = Math.round(height * ratio);
                    const canvas = document.createElement('canvas');
                    canvas.width = width; canvas.height = height;
                    canvas.getContext('2d').drawImage(img, 0, 0, width, height);
                    canvas.toBlob(
                        (blob) => resolve(new File([blob], file.name, { type: 'image/jpeg', lastModified: Date.now() })),
                        'image/jpeg', quality
                    );
                };
                img.src = e.target.result;
            };
            reader.readAsDataURL(file);
        });
    }

    function formatMB(bytes) { return (bytes / 1024 / 1024).toFixed(2) + ' MB'; }

    function showSizeAlert(container, files) {
        let el = container.querySelector('.size-alert');
        if (!el) {
            el = document.createElement('div');
            el.className = 'size-alert flex items-start gap-2 bg-amber-50 border border-amber-400 text-amber-800 text-sm px-4 py-3 rounded mt-2';
            container.appendChild(el);
        }
        const list = files.map(f => `<li><strong>${f.name}</strong> — ${formatMB(f.size)}</li>`).join('');
        el.innerHTML = `
            <svg class="w-5 h-5 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
            </svg>
            <div>
              <p class="font-semibold">Large image${files.length > 1 ? 's' : ''} detected — compressing automatically…</p>
              <ul class="list-disc pl-4 mt-1">${list}</ul>
              <p class="mt-1 text-xs text-amber-700">
                Images above 2 MB slow down uploads. They are being resized to max 1920 × 1080 px before submission.
              </p>
            </div>`;
    }

    function showDoneAlert(container) {
        let el = container.querySelector('.size-alert');
        if (!el) return;
        el.className = 'size-alert flex items-start gap-2 bg-green-50 border border-green-400 text-green-800 text-sm px-4 py-3 rounded mt-2';
        el.innerHTML = `
            <svg class="w-5 h-5 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            <div><p class="font-semibold">Images compressed successfully. Ready to upload.</p></div>`;
        setTimeout(() => { el?.remove(); }, 4000);
    }

    function showProgress(container) {
        let el = container.querySelector('.compress-progress');
        if (!el) {
            el = document.createElement('div');
            el.className = 'compress-progress mt-2';
            el.innerHTML = `
                <div class="flex items-center gap-2 text-xs text-gray-500 mb-1">
                  <svg class="animate-spin w-3 h-3" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                  </svg>
                  Compressing images, please wait…
                </div>
                <div class="w-full bg-gray-200 rounded h-1.5">
                  <div class="compress-bar bg-[#613bf1] h-1.5 rounded transition-all duration-300" style="width:0%"></div>
                </div>`;
            container.appendChild(el);
        }
        return el;
    }

    function updateProgress(bar, pct) { bar.querySelector('.compress-bar').style.width = pct + '%'; }
    function hideProgress(container)  { container.querySelector('.compress-progress')?.remove(); }

    /* ─── Wire up ─── */
    const editorConfig = {
        toolbar: ['heading','|','bold','italic','link','bulletedList','numberedList','undo','redo','code','codeBlock'],
        removePlugins: ['Heading']
    };

    ['desc', 'specifications'].forEach(id => {
        const el = document.querySelector('#' + id);
        if (window.ClassicEditor && el) {
            ClassicEditor.create(el, editorConfig).catch(console.error);
        }
    });

    const input     = document.getElementById('newImages');
    const preview   = document.getElementById('previewNew');
    const alertArea = document.getElementById('image-alert-area');
    const MAX_BYTES = 2 * 1024 * 1024; // 2 MB

    if (input && preview) {
        input.addEventListener('change', async () => {
            const raw = Array.from(input.files ?? []);
            if (!raw.length) {
                preview.innerHTML = '<p class="text-gray-400 text-sm">No new images</p>';
                alertArea.innerHTML = '';
                return;
            }

            const oversized = raw.filter(f => f.size > MAX_BYTES);
            alertArea.innerHTML = '';

            if (oversized.length) showSizeAlert(alertArea, oversized);

            const progBar = oversized.length ? showProgress(alertArea) : null;

            const files = [];
            for (let i = 0; i < raw.length; i++) {
                files.push(raw[i].size > MAX_BYTES
                    ? await compressImage(raw[i])
                    : raw[i]);
                if (progBar) updateProgress(progBar, Math.round(((i + 1) / raw.length) * 100));
            }

            hideProgress(alertArea);
            if (oversized.length) showDoneAlert(alertArea);

            /* Sync to input */
            const dt = new DataTransfer();
            files.forEach(f => dt.items.add(f));
            input.files = dt.files;

            /* Render previews */
            preview.innerHTML = '';
            files.forEach((file, index) => {
                const url     = URL.createObjectURL(file);
                const div     = document.createElement('div');
                div.className = 'relative w-24 h-24 border rounded overflow-hidden';

                const img     = document.createElement('img');
                img.src       = url;
                img.className = 'w-full h-full object-cover';

                const tag     = document.createElement('span');
                tag.className = 'absolute bottom-0 left-0 right-0 bg-black/50 text-white text-[9px] text-center py-0.5';
                tag.textContent = formatMB(file.size);

                const btn     = document.createElement('button');
                btn.type      = 'button';
                btn.innerHTML = '&times;';
                btn.className = 'absolute top-0 right-0 bg-red-600 text-white w-5 h-5 rounded-full text-xs';
                btn.onclick   = () => {
                    files.splice(index, 1);
                    const dt2 = new DataTransfer();
                    files.forEach(f => dt2.items.add(f));
                    input.files = dt2.files;
                    div.remove();
                    if (!files.length) preview.innerHTML = '<p class="text-gray-400 text-sm">No new images</p>';
                };

                div.append(img, tag, btn);
                preview.appendChild(div);
            });
        });
    }

    function removeOldImage(button) {
        button.parentElement.remove();
    }
    </script>
@endsection