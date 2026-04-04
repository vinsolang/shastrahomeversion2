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

                {{-- size alert and progress bar will be injected here by JS --}}
                <div id="image-alert-area"></div>

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
        setTimeout(() => { if (el) el.remove(); }, 4000);
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
    function hideProgress(container) { container.querySelector('.compress-progress')?.remove(); }

    /* ─── Wire up ─── */
    window.addEventListener('load', () => {
        /* CKEditor */
        ['desc', 'specifications'].forEach(id => {
            const el = document.querySelector('#' + id);
            if (window.ClassicEditor && el) {
                ClassicEditor.create(el, {
                    toolbar: ['heading','|','bold','italic','link','bulletedList','numberedList','undo','redo','code','codeBlock'],
                    removePlugins: ['Heading']
                }).catch(console.error);
            }
        });

        /* Image upload */
        const input      = document.getElementById('projectImages');
        const preview    = document.getElementById('color-preview');
        const alertArea  = document.getElementById('image-alert-area');
        const MAX_BYTES  = 2 * 1024 * 1024; // 2 MB

        if (!input || !preview) return;

        input.addEventListener('change', async () => {
            const raw = Array.from(input.files ?? []);
            if (!raw.length) {
                preview.innerHTML = '<p class="text-gray-400 text-sm">No images selected.</p>';
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
                const wrapper = document.createElement('div');
                wrapper.className = 'relative w-24 h-24 border rounded overflow-hidden';

                const img     = document.createElement('img');
                img.src       = url;
                img.className = 'w-full h-full object-cover';

                const tag     = document.createElement('span');
                tag.className = 'absolute bottom-0 left-0 right-0 bg-black/50 text-white text-[9px] text-center py-0.5';
                tag.textContent = formatMB(file.size);

                const btn     = document.createElement('button');
                btn.type      = 'button';
                btn.innerHTML = '&times;';
                btn.className = 'absolute top-0 right-0 bg-red-600 text-white w-5 h-5 rounded-full text-xs flex items-center justify-center';
                btn.onclick   = () => {
                    files.splice(index, 1);
                    const dt2 = new DataTransfer();
                    files.forEach(f => dt2.items.add(f));
                    input.files = dt2.files;
                    wrapper.remove();
                    if (!files.length) preview.innerHTML = '<p class="text-gray-400 text-sm">No images selected.</p>';
                };

                wrapper.append(img, tag, btn);
                preview.appendChild(wrapper);
            });
        });
    });
    </script>
@endsection