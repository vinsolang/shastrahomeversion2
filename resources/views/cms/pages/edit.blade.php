@extends('layouts.cms')

@section('title', $pageDefinition['label'] . ' | Shastra CMS')

@section('content')
    {{-- Page editor header --}}
    <section class="rounded-[2rem] bg-white p-6 shadow-sm">
        <p class="text-sm uppercase tracking-[0.3em] text-amber-500">Page Editor</p>
        <h1 class="mt-3 text-3xl font-semibold tracking-tight text-slate-900">{{ $pageDefinition['label'] }}</h1>
        <p class="mt-3 max-w-3xl text-sm leading-6 text-slate-600">
            This editor manages the fixed section schema for the {{ strtolower($pageDefinition['label']) }} page. JSON fields should remain arrays or objects so the frontend can keep rendering the same structure.
        </p>
    </section>

    {{-- Page editor form --}}
    <section class="rounded-[2rem] bg-white p-6 shadow-sm">
        <form method="POST" action="{{ route('cms.pages.update', ['page' => $pageSlug]) }}" class="space-y-6">
            @csrf
            @method('PUT')

            @foreach ($pageDefinition['sections'] as $section)
                <article class="rounded-[1.5rem] border border-slate-200 p-5">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <h2 class="text-lg font-semibold text-slate-900">{{ $section['label'] }}</h2>
                            <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-600">{{ $section['help'] }}</p>
                        </div>
                    </div>

                    <div class="mt-4">
                        <label for="section-{{ $section['key'] }}" class="sr-only">{{ $section['label'] }}</label>

                        @if ($section['type'] === 'text')
                            <input
                                id="section-{{ $section['key'] }}"
                                type="text"
                                name="sections[{{ $section['key'] }}]"
                                value="{{ old("sections.{$section['key']}", $values[$section['key']] ?? '') }}"
                                class="block w-full rounded-[1.25rem] border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-amber-400"
                            >
                        @elseif ($section['type'] === 'textarea')
                            <textarea
                                id="section-{{ $section['key'] }}"
                                name="sections[{{ $section['key'] }}]"
                                rows="5"
                                class="block w-full rounded-[1.25rem] border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-amber-400"
                            >{{ old("sections.{$section['key']}", $values[$section['key']] ?? '') }}</textarea>
                        @else
                            <textarea
                                id="section-{{ $section['key'] }}"
                                name="sections[{{ $section['key'] }}]"
                                rows="14"
                                class="block w-full rounded-[1.25rem] border border-slate-300 bg-slate-950 px-4 py-4 font-mono text-sm text-slate-100 outline-none transition focus:border-amber-400"
                            >{{ old("sections.{$section['key']}", $values[$section['key']] ?? '') }}</textarea>
                        @endif

                        @error("sections.{$section['key']}")
                            <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>
                </article>
            @endforeach

            <div class="flex items-center justify-between gap-4">
                <a
                    href="{{ route($pageDefinition['route']) }}"
                    target="_blank"
                    rel="noreferrer"
                    class="inline-flex items-center justify-center rounded-full border border-slate-300 px-5 py-3 text-sm font-medium text-slate-700 transition hover:border-slate-400 hover:bg-slate-50"
                >
                    Open page
                </a>

                <button
                    type="submit"
                    class="inline-flex items-center justify-center rounded-full bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-700"
                >
                    Save {{ strtolower($pageDefinition['label']) }} page
                </button>
            </div>
        </form>
    </section>
@endsection
