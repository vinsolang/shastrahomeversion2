@extends('admin.layouts.app')

@section('header')
    Global Settings
@endsection

@section('content')
    <div class="max-w-7xl mx-auto space-y-6">
        @component('admin.components.alert')
        @endcomponent

        @if ($errors->any())
            <div class="rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-700">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <section class="rounded-3xl bg-white p-6 shadow-sm space-y-5">
                <div>
                    <h2 class="text-xl font-semibold text-slate-900">Brand</h2>
                </div>

                <div class="grid gap-4">
                    <div><label class="block text-sm font-medium text-slate-700 mb-2">Brand Name</label><input type="text"
                            name="sections[brand][name]"
                            value="{{ old('sections.brand.name', data_get($values, 'brand.name', '')) }}"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-900"></div>
                </div>
            </section>

            <input type="hidden" name="sections[brand][location]"
                value="{{ old('sections.brand.location', data_get($values, 'brand.location', '')) }}">

            <section class="rounded-3xl bg-white p-6 shadow-sm space-y-5">
                <div>
                    <h2 class="text-xl font-semibold text-slate-900">Contact</h2>
                </div>

                <div class="grid gap-4 md:grid-cols-2">
                    @foreach (range(0, 1) as $index)
                        <div><label class="block text-sm font-medium text-slate-700 mb-2">Address Line
                                {{ $index + 1 }}</label><input type="text" name="sections[contact][address_lines][{{ $index }}]"
                                value="{{ old("sections.contact.address_lines.{$index}", data_get($values, "contact.address_lines.{$index}", '')) }}"
                                class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-900"></div>
                    @endforeach
                    @foreach (range(0, 1) as $index)
                        <div><label class="block text-sm font-medium text-slate-700 mb-2">Phone {{ $index + 1 }}</label><input
                                type="text" name="sections[contact][phones][{{ $index }}]"
                                value="{{ old("sections.contact.phones.{$index}", data_get($values, "contact.phones.{$index}", '')) }}"
                                class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-900"></div>
                    @endforeach
                    <div><label class="block text-sm font-medium text-slate-700 mb-2">Hours</label><input type="text"
                            name="sections[contact][hours]"
                            value="{{ old('sections.contact.hours', data_get($values, 'contact.hours', '')) }}"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-900"></div>
                    <div><label class="block text-sm font-medium text-slate-700 mb-2">Email</label><input type="email"
                            name="sections[contact][email]"
                            value="{{ old('sections.contact.email', data_get($values, 'contact.email', '')) }}"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-900"></div>
                </div>

                <div class="space-y-4">
                    <h3 class="text-base font-semibold text-slate-800">Social Links</h3>
                    @foreach (range(0, 3) as $index)
                        <input type="hidden" name="sections[contact][socials][{{ $index }}][label]"
                            value="{{ old("sections.contact.socials.{$index}.label", data_get($values, "contact.socials.{$index}.label", '')) }}">
                        <input type="hidden" name="sections[contact][socials][{{ $index }}][icon]"
                            value="{{ old("sections.contact.socials.{$index}.icon", data_get($values, "contact.socials.{$index}.icon", '')) }}">
                        @php
                            $platformLabel = data_get($values, "contact.socials.{$index}.label", "Social {$index}");
                        @endphp
                        <div class="grid gap-4 md:grid-cols-3">
                            <div class="md:col-span-1 flex items-end">
                                <div
                                    class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-medium text-slate-700">
                                    {{ $platformLabel }}
                                </div>
                            </div>
                            <div class="md:col-span-2">
                                <input type="text" name="sections[contact][socials][{{ $index }}][href]"
                                    value="{{ old("sections.contact.socials.{$index}.href", data_get($values, "contact.socials.{$index}.href", '')) }}"
                                    placeholder="{{ $platformLabel }} URL"
                                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-900">
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            @php
                $footerTeamImage = old('sections.footer.team.image', data_get($values, 'footer.team.image', ''));
                $footerTeamPreview = null;

                if (filled($footerTeamImage)) {
                    $isPublicAsset = str_starts_with($footerTeamImage, 'assets/');
                    $assetPath = public_path($footerTeamImage);
                    $storagePath = storage_path('app/public/' . $footerTeamImage);

                    if (($isPublicAsset && file_exists($assetPath)) || (!$isPublicAsset && file_exists($storagePath))) {
                        $footerTeamPreview = $isPublicAsset
                            ? asset($footerTeamImage)
                            : route('public.media.show', ['path' => $footerTeamImage]);
                    }
                }
            @endphp

            <section class="rounded-3xl bg-white p-6 shadow-sm space-y-5">
                <div>
                    <h2 class="text-xl font-semibold text-slate-900">Footer</h2>
                </div>

                <div class="grid gap-4 md:grid-cols-2">
                    <div><label class="block text-sm font-medium text-slate-700 mb-2">CTA Headline</label><input type="text"
                            name="sections[footer][cta][headline]"
                            value="{{ old('sections.footer.cta.headline', data_get($values, 'footer.cta.headline', '')) }}"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-900"></div>
                    <div><label class="block text-sm font-medium text-slate-700 mb-2">CTA Button Label</label><input
                            type="text" name="sections[footer][cta][button_label]"
                            value="{{ old('sections.footer.cta.button_label', data_get($values, 'footer.cta.button_label', '')) }}"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-900"></div>
                    <div><label class="block text-sm font-medium text-slate-700 mb-2">Description Heading</label><input
                            type="text" name="sections[footer][description_heading]"
                            value="{{ old('sections.footer.description_heading', data_get($values, 'footer.description_heading', '')) }}"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-900"></div>
                    <div><label class="block text-sm font-medium text-slate-700 mb-2">Copyright</label><input type="text"
                            name="sections[footer][legal][copyright]"
                            value="{{ old('sections.footer.legal.copyright', data_get($values, 'footer.legal.copyright', '')) }}"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-900"></div>
                </div>

                <div class="grid gap-4">
                    @foreach (range(0, 1) as $index)
                        <div><label class="block text-sm font-medium text-slate-700 mb-2">Footer Description Paragraph
                                {{ $index + 1 }}</label><textarea name="sections[footer][description][{{ $index }}]" rows="3"
                                class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-900">{{ old("sections.footer.description.{$index}", data_get($values, "footer.description.{$index}", '')) }}</textarea>
                        </div>
                    @endforeach
                </div>

                <div class="space-y-3">
                    <label class="block text-sm font-medium text-slate-700">Footer Team Image</label>

                    {{-- Preview --}}
                    <div>
                        <img id="footerPreview" src="{{ $footerTeamPreview ?? '' }}"
                            class="w-64 h-40 max-w-md rounded-2xl border border-slate-200 object-cover {{ $footerTeamPreview ? '' : 'hidden' }}"
                            alt="Footer team image">

                        {{-- Empty state --}}
                        <div id="footerPlaceholder"
                            class="rounded-2xl border border-dashed border-slate-300 px-4 py-5 text-sm text-slate-500 {{ $footerTeamPreview ? 'hidden' : '' }}">
                            No footer team image set.
                        </div>
                    </div>

                    {{-- File input --}}
                    <input type="file" name="uploads[footer_team_image]" accept="image/*"
                        onchange="previewFooterImage(event)"
                        class="block w-full max-w-md rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-900">

                    @error('uploads.footer_team_image')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    <p class="text-xs text-slate-500">
                        Upload a new image to replace the current footer team image. Maximum file size: 16 MB.
                    </p>
                </div>
            </section>

            @foreach (range(0, 1) as $index)
                <input type="hidden" name="sections[footer][team][message][{{ $index }}]"
                    value="{{ old("sections.footer.team.message.{$index}", data_get($values, "footer.team.message.{$index}", '')) }}">
            @endforeach
            <input type="hidden" name="sections[footer][cta][emphasis]"
                value="{{ old('sections.footer.cta.emphasis', data_get($values, 'footer.cta.emphasis', '')) }}">
            <input type="hidden" name="sections[footer][cta][accent]"
                value="{{ old('sections.footer.cta.accent', data_get($values, 'footer.cta.accent', '')) }}">
            <input type="hidden" name="sections[footer][cta][button_route]"
                value="{{ old('sections.footer.cta.button_route', data_get($values, 'footer.cta.button_route', '')) }}">
            <input type="hidden" name="sections[footer][cta][background_image]"
                value="{{ old('sections.footer.cta.background_image', data_get($values, 'footer.cta.background_image', '')) }}">
            <input type="hidden" name="sections[footer][team][eyebrow]"
                value="{{ old('sections.footer.team.eyebrow', data_get($values, 'footer.team.eyebrow', '')) }}">
            <input type="hidden" name="sections[footer][team][caption]"
                value="{{ old('sections.footer.team.caption', data_get($values, 'footer.team.caption', '')) }}">
            <input type="hidden" name="sections[footer][team][image]"
                value="{{ old('sections.footer.team.image', data_get($values, 'footer.team.image', '')) }}">

            @foreach (range(0, 5) as $index)
                <input type="hidden" name="sections[footer][logo_strip][items][{{ $index }}][label]"
                    value="{{ old("sections.footer.logo_strip.items.{$index}.label", data_get($values, "sections.footer.logo_strip.items.{$index}.label", data_get($values, "footer.logo_strip.items.{$index}.label", ''))) }}">
                <input type="hidden" name="sections[footer][company_links][{{ $index }}][label]"
                    value="{{ old("sections.footer.company_links.{$index}.label", data_get($values, "footer.company_links.{$index}.label", '')) }}">
                <input type="hidden" name="sections[footer][company_links][{{ $index }}][route]"
                    value="{{ old("sections.footer.company_links.{$index}.route", data_get($values, "footer.company_links.{$index}.route", '')) }}">
            @endforeach

            @foreach (range(0, 1) as $index)
                <input type="hidden" name="sections[footer][legal][links][{{ $index }}][label]"
                    value="{{ old("sections.footer.legal.links.{$index}.label", data_get($values, "footer.legal.links.{$index}.label", '')) }}">
                <input type="hidden" name="sections[footer][legal][links][{{ $index }}][href]"
                    value="{{ old("sections.footer.legal.links.{$index}.href", data_get($values, "footer.legal.links.{$index}.href", '')) }}">
            @endforeach

            <div class="flex justify-end">
                <button type="submit"
                    class="inline-flex items-center rounded-full bg-[#613bf1] px-6 py-3 text-sm font-semibold text-white shadow-[0_12px_24px_rgba(97,59,241,0.25)]">
                    Save Global Settings
                </button>
            </div>
        </form>
    </div>

    <script>
function previewFooterImage(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('footerPreview');
    const placeholder = document.getElementById('footerPlaceholder');

    if (file) {
        const reader = new FileReader();

        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.classList.remove('hidden');
            placeholder.classList.add('hidden');
        };

        reader.readAsDataURL(file);
    }
}
</script>
@endsection