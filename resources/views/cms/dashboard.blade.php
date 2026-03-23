@extends('layouts.cms')

@section('title', 'Shastra CMS')

@section('content')
    {{-- Dashboard summary --}}
    <section class="rounded-[2rem] bg-white p-6 shadow-sm">
        <p class="text-sm uppercase tracking-[0.3em] text-amber-500">Overview</p>
        <h1 class="mt-3 text-3xl font-semibold tracking-tight text-slate-900">Content dashboard</h1>
        <p class="mt-3 max-w-3xl text-sm leading-6 text-slate-600">
            The marketing frontend still renders from the existing site structure, with database overrides layered on top. Use the editors below to update fixed-schema content without changing the Blade layout system.
        </p>
    </section>

    {{-- Dashboard metrics --}}
    <section class="grid gap-4 md:grid-cols-3">
        <article class="rounded-[2rem] bg-white p-6 shadow-sm">
            <p class="text-sm text-slate-500">Editable pages</p>
            <p class="mt-2 text-3xl font-semibold text-slate-900">{{ count($editablePages) }}</p>
        </article>

        <article class="rounded-[2rem] bg-white p-6 shadow-sm">
            <p class="text-sm text-slate-500">Contact submissions</p>
            <p class="mt-2 text-3xl font-semibold text-slate-900">{{ $submissionCount }}</p>
        </article>

        <article class="rounded-[2rem] bg-white p-6 shadow-sm">
            <p class="text-sm text-slate-500">Brand name</p>
            <p class="mt-2 text-2xl font-semibold text-slate-900">{{ data_get($site, 'brand.name', 'Shastra Home') }}</p>
        </article>
    </section>

    {{-- Dashboard quick links --}}
    <section class="grid gap-4 xl:grid-cols-2">
        <article class="rounded-[2rem] bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <h2 class="text-xl font-semibold text-slate-900">Global settings</h2>
                    <p class="mt-2 text-sm leading-6 text-slate-600">
                        Update shared brand, navigation, contact, and footer content.
                    </p>
                </div>

                <a
                    href="{{ route('cms.settings.edit') }}"
                    class="inline-flex shrink-0 items-center justify-center rounded-full border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 transition hover:border-slate-400 hover:bg-slate-50"
                >
                    Edit settings
                </a>
            </div>
        </article>

        <article class="rounded-[2rem] bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <h2 class="text-xl font-semibold text-slate-900">Contact inbox</h2>
                    <p class="mt-2 text-sm leading-6 text-slate-600">
                        Review incoming marketing leads stored from the live contact form.
                    </p>
                </div>

                <a
                    href="{{ route('cms.contact-submissions.index') }}"
                    class="inline-flex shrink-0 items-center justify-center rounded-full border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 transition hover:border-slate-400 hover:bg-slate-50"
                >
                    View inbox
                </a>
            </div>
        </article>
    </section>

    {{-- Dashboard page editors --}}
    <section class="rounded-[2rem] bg-white p-6 shadow-sm">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="text-xl font-semibold text-slate-900">Page editors</h2>
                <p class="mt-2 text-sm leading-6 text-slate-600">
                    These editors manage fixed sections only. Layout, animation, and Blade structure remain in code.
                </p>
            </div>
        </div>

        <div class="mt-6 grid gap-4 md:grid-cols-2">
            @foreach ($editablePages as $slug => $page)
                <article class="rounded-[1.75rem] border border-slate-200 p-5">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <h3 class="text-lg font-semibold text-slate-900">{{ $page['label'] }}</h3>
                            <p class="mt-2 text-sm text-slate-600">
                                Route:
                                <a href="{{ route($page['route']) }}" class="text-amber-600 underline underline-offset-4" target="_blank" rel="noreferrer">
                                    {{ route($page['route']) }}
                                </a>
                            </p>
                        </div>

                        <a
                            href="{{ route('cms.pages.edit', ['page' => $slug]) }}"
                            class="inline-flex shrink-0 items-center justify-center rounded-full bg-slate-900 px-4 py-2 text-sm font-medium text-white transition hover:bg-slate-700"
                        >
                            Edit
                        </a>
                    </div>
                </article>
            @endforeach
        </div>
    </section>
@endsection
