@extends('admin.layouts.app')

@section('header')
    Contact
@endsection

@section('content')
    @php
        $mediaUrl = static function (?string $path): ?string {
            if (! filled($path)) {
                return null;
            }

            return str_starts_with($path, 'assets/')
                ? asset($path)
                : route('public.media.show', ['path' => $path]);
        };
        $heroPosterPath = old('sections.hero.poster', data_get($values, 'hero.poster', ''));
    @endphp

    <div class="max-w-6xl mx-auto space-y-6">
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

        <form action="{{ route('cms.pages.update', ['page' => $pageSlug]) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <section class="rounded-3xl bg-white p-6 shadow-sm space-y-5">
                <div>
                    <h2 class="text-xl font-semibold text-slate-900">Page Basics</h2>
                    <p class="mt-1 text-sm text-slate-500">Contact page title and summary copy.</p>
                </div>

                <div class="grid gap-4">
                    <div><label class="block text-sm font-medium text-slate-700 mb-2">Title</label><input type="text" name="sections[title]" value="{{ old('sections.title', data_get($values, 'title', '')) }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-900"></div>
                    <div><label class="block text-sm font-medium text-slate-700 mb-2">Description</label><textarea name="sections[description]" rows="4" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-900">{{ old('sections.description', data_get($values, 'description', '')) }}</textarea></div>
                </div>
            </section>

            <section class="rounded-3xl bg-white p-6 shadow-sm space-y-5">
                <div>
                    <h2 class="text-xl font-semibold text-slate-900">Hero</h2>
                    <p class="mt-1 text-sm text-slate-500">Main contact-page headline and hero poster image.</p>
                </div>

                <div class="grid gap-4">
                    <div><label class="block text-sm font-medium text-slate-700 mb-2">Headline</label><input type="text" name="sections[hero][headline]" value="{{ old('sections.hero.headline', data_get($values, 'hero.headline', '')) }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-900"></div>

                    <div class="space-y-3">
                        <label class="block text-sm font-medium text-slate-700">Hero Poster</label>
                        @if ($heroPosterPath)
                            <img src="{{ $mediaUrl($heroPosterPath) }}" class="w-full rounded-2xl border border-slate-200 object-cover" alt="Contact hero poster">
                        @else
                            <div class="rounded-2xl border border-dashed border-slate-300 px-4 py-5 text-sm text-slate-500">No hero poster set.</div>
                        @endif
                        <input type="file" name="uploads[contact_hero_poster]" accept="image/*" class="block w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-900">
                    </div>
                </div>
            </section>

            <input type="hidden" name="sections[hero][eyebrow]" value="{{ old('sections.hero.eyebrow', data_get($values, 'hero.eyebrow', '')) }}">
            <input type="hidden" name="sections[hero][accent]" value="{{ old('sections.hero.accent', data_get($values, 'hero.accent', '')) }}">
            <input type="hidden" name="sections[hero][description]" value="{{ old('sections.hero.description', data_get($values, 'hero.description', '')) }}">
            <input type="hidden" name="sections[hero][video]" value="{{ old('sections.hero.video', data_get($values, 'hero.video', '')) }}">
            <input type="hidden" name="sections[hero][poster]" value="{{ $heroPosterPath }}">

            <section class="rounded-3xl bg-white p-6 shadow-sm space-y-5">
                <div>
                    <h2 class="text-xl font-semibold text-slate-900">Form Essentials</h2>
                    <p class="mt-1 text-sm text-slate-500">Only the key form content is editable here.</p>
                </div>

                <div class="grid gap-4 md:grid-cols-2">
                    <div class="md:col-span-2"><label class="block text-sm font-medium text-slate-700 mb-2">Form Title</label><input type="text" name="sections[form][title]" value="{{ old('sections.form.title', data_get($values, 'form.title', '')) }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-900"></div>
                    <div><label class="block text-sm font-medium text-slate-700 mb-2">Submit Label</label><input type="text" name="sections[form][submit_label]" value="{{ old('sections.form.submit_label', data_get($values, 'form.submit_label', '')) }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-900"></div>
                </div>

                <div class="space-y-4 rounded-2xl border border-slate-200 bg-slate-50/70 p-4">
                    <div>
                        <h3 class="text-base font-semibold text-slate-800">Project Type Options</h3>
                        <p class="mt-1 text-sm text-slate-500">These options appear in the project type dropdown.</p>
                    </div>

                    <div class="grid gap-4 md:grid-cols-2">
                        @foreach (range(0, 3) as $index)
                            <div><label class="block text-sm font-medium text-slate-700 mb-2">Option {{ $index + 1 }}</label><input type="text" name="sections[form][fields][project_type][options][{{ $index }}]" value="{{ old("sections.form.fields.project_type.options.{$index}", data_get($values, "form.fields.project_type.options.{$index}", '')) }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-900"></div>
                        @endforeach
                    </div>
                </div>
            </section>

            <input type="hidden" name="sections[form][fields][first_name][label]" value="{{ old('sections.form.fields.first_name.label', data_get($values, 'form.fields.first_name.label', '')) }}">
            <input type="hidden" name="sections[form][fields][first_name][placeholder]" value="{{ old('sections.form.fields.first_name.placeholder', data_get($values, 'form.fields.first_name.placeholder', '')) }}">
            <input type="hidden" name="sections[form][fields][last_name][label]" value="{{ old('sections.form.fields.last_name.label', data_get($values, 'form.fields.last_name.label', '')) }}">
            <input type="hidden" name="sections[form][fields][last_name][placeholder]" value="{{ old('sections.form.fields.last_name.placeholder', data_get($values, 'form.fields.last_name.placeholder', '')) }}">
            <input type="hidden" name="sections[form][fields][email_address][label]" value="{{ old('sections.form.fields.email_address.label', data_get($values, 'form.fields.email_address.label', '')) }}">
            <input type="hidden" name="sections[form][fields][email_address][placeholder]" value="{{ old('sections.form.fields.email_address.placeholder', data_get($values, 'form.fields.email_address.placeholder', '')) }}">
            <input type="hidden" name="sections[form][fields][project_type][label]" value="{{ old('sections.form.fields.project_type.label', data_get($values, 'form.fields.project_type.label', '')) }}">
            <input type="hidden" name="sections[form][fields][project_type][placeholder]" value="{{ old('sections.form.fields.project_type.placeholder', data_get($values, 'form.fields.project_type.placeholder', '')) }}">
            <input type="hidden" name="sections[form][fields][message][label]" value="{{ old('sections.form.fields.message.label', data_get($values, 'form.fields.message.label', '')) }}">
            <input type="hidden" name="sections[form][fields][message][placeholder]" value="{{ old('sections.form.fields.message.placeholder', data_get($values, 'form.fields.message.placeholder', '')) }}">
            <input type="hidden" name="sections[form][fields][message][rows]" value="{{ old('sections.form.fields.message.rows', data_get($values, 'form.fields.message.rows', '')) }}">
            <input type="hidden" name="sections[media][headline_prefix]" value="{{ old('sections.media.headline_prefix', data_get($values, 'media.headline_prefix', '')) }}">
            <input type="hidden" name="sections[media][headline_emphasis]" value="{{ old('sections.media.headline_emphasis', data_get($values, 'media.headline_emphasis', '')) }}">
            <input type="hidden" name="sections[media][headline_suffix]" value="{{ old('sections.media.headline_suffix', data_get($values, 'media.headline_suffix', '')) }}">
            <input type="hidden" name="sections[media][accent]" value="{{ old('sections.media.accent', data_get($values, 'media.accent', '')) }}">
            <input type="hidden" name="sections[media][video]" value="{{ old('sections.media.video', data_get($values, 'media.video', '')) }}">

            <div class="flex justify-end">
                <button type="submit" class="inline-flex items-center rounded-full bg-[#613bf1] px-6 py-3 text-sm font-semibold text-white shadow-[0_12px_24px_rgba(97,59,241,0.25)]">
                    Save Contact Content
                </button>
            </div>
        </form>
    </div>
@endsection
