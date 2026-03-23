@extends('layouts.cms')

@section('title', 'Global Settings | Shastra CMS')

@section('content')
    {{-- Global settings header --}}
    <section class="rounded-[2rem] bg-white p-6 shadow-sm">
        <p class="text-sm uppercase tracking-[0.3em] text-amber-500">Global Settings</p>
        <h1 class="mt-3 text-3xl font-semibold tracking-tight text-slate-900">Shared marketing content</h1>
        <p class="mt-3 max-w-3xl text-sm leading-6 text-slate-600">
            These sections feed the marketing shell around the page content. Use valid JSON objects or arrays for each section.
        </p>
    </section>

    {{-- Global settings form --}}
    <section class="rounded-[2rem] bg-white p-6 shadow-sm">
        <form method="POST" action="{{ route('cms.settings.update') }}" class="space-y-6">
            @csrf
            @method('PUT')

            @foreach ($sections as $section)
                <article class="rounded-[1.5rem] border border-slate-200 p-5">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <h2 class="text-lg font-semibold text-slate-900">{{ $section['label'] }}</h2>
                            <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-600">{{ $section['help'] }}</p>
                        </div>
                    </div>

                    <div class="mt-4">
                        <label for="section-{{ $section['key'] }}" class="sr-only">{{ $section['label'] }}</label>
                        <textarea
                            id="section-{{ $section['key'] }}"
                            name="sections[{{ $section['key'] }}]"
                            rows="14"
                            class="block w-full rounded-[1.25rem] border border-slate-300 bg-slate-950 px-4 py-4 font-mono text-sm text-slate-100 outline-none transition focus:border-amber-400"
                        >{{ old("sections.{$section['key']}", $values[$section['key']] ?? '') }}</textarea>

                        @error("sections.{$section['key']}")
                            <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>
                </article>
            @endforeach

            <div class="flex justify-end">
                <button
                    type="submit"
                    class="inline-flex items-center justify-center rounded-full bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-700"
                >
                    Save global settings
                </button>
            </div>
        </form>
    </section>
@endsection
