@extends('admin.layouts.app')

@section('header')
    Home
@endsection

@section('content')
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

        <form action="{{ route('cms.pages.update', ['page' => $pageSlug]) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <section class="rounded-3xl bg-white p-6 shadow-sm space-y-5">
                <div>
                    <h2 class="text-xl font-semibold text-slate-900">Hero</h2>
                    <p class="mt-1 text-sm text-slate-500">Main hero text and primary call to action.</p>
                </div>

                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Title</label>
                        <input type="text" name="sections[hero][title]" value="{{ old('sections.hero.title', data_get($values, 'hero.title', '')) }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-900">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Primary CTA Label</label>
                        <input type="text" name="sections[hero][primaryCta][label]" value="{{ old('sections.hero.primaryCta.label', data_get($values, 'hero.primaryCta.label', '')) }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-900">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-2">Description</label>
                        <textarea name="sections[hero][description]" rows="4" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-900">{{ old('sections.hero.description', data_get($values, 'hero.description', '')) }}</textarea>
                    </div>
                </div>
            </section>

            <input type="hidden" name="sections[hero][eyebrow]" value="{{ old('sections.hero.eyebrow', data_get($values, 'hero.eyebrow', '')) }}">
            <input type="hidden" name="sections[hero][titleAccent]" value="{{ old('sections.hero.titleAccent', data_get($values, 'hero.titleAccent', '')) }}">
            <input type="hidden" name="sections[hero][primaryCta][route]" value="{{ old('sections.hero.primaryCta.route', data_get($values, 'hero.primaryCta.route', '')) }}">
            <input type="hidden" name="sections[hero][secondaryCta][label]" value="{{ old('sections.hero.secondaryCta.label', data_get($values, 'hero.secondaryCta.label', '')) }}">
            <input type="hidden" name="sections[hero][secondaryCta][route]" value="{{ old('sections.hero.secondaryCta.route', data_get($values, 'hero.secondaryCta.route', '')) }}">
            <input type="hidden" name="sections[hero][videos][0][label]" value="{{ old('sections.hero.videos.0.label', data_get($values, 'hero.videos.0.label', '')) }}">
            <input type="hidden" name="sections[hero][videos][0][src]" value="{{ old('sections.hero.videos.0.src', data_get($values, 'hero.videos.0.src', '')) }}">

            <section class="rounded-3xl bg-white p-6 shadow-sm space-y-5">
                <div>
                    <h2 class="text-xl font-semibold text-slate-900">Stats</h2>
                    <p class="mt-1 text-sm text-slate-500">Three fixed KPI cards shown on the homepage.</p>
                </div>

                <div class="space-y-4">
                    @foreach (range(0, 2) as $index)
                        <div class="grid gap-4 md:grid-cols-2">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">Stat Value {{ $index + 1 }}</label>
                                <input type="text" name="sections[stats][{{ $index }}][value]" value="{{ old("sections.stats.{$index}.value", data_get($values, "stats.{$index}.value", '')) }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-900">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">Stat Label {{ $index + 1 }}</label>
                                <input type="text" name="sections[stats][{{ $index }}][label]" value="{{ old("sections.stats.{$index}.label", data_get($values, "stats.{$index}.label", '')) }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-900">
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <div class="flex justify-end">
                <button type="submit" class="inline-flex items-center rounded-full bg-[#613bf1] px-6 py-3 text-sm font-semibold text-white shadow-[0_12px_24px_rgba(97,59,241,0.25)]">
                    Save Home Content
                </button>
            </div>
        </form>
    </div>
@endsection
