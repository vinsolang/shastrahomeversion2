@extends('admin.layouts.app')

@section('header')
    Projects
@endsection

@section('content')

    <style>
        .my-scroll::-webkit-scrollbar {
            width: 4px;
            height: 4px;
        }

        .my-scroll::-webkit-scrollbar-thumb {
            background: #64748b;
            border-radius: 10px;
        }
    </style>

    <div class="max-w-[1520px] mx-auto py-3">
        <div class="overflow-hidden rounded-[28px] border border-white/70 bg-white/55 shadow-[0_20px_60px_rgba(15,23,42,0.08)] backdrop-blur-sm">
            <div class="border-b border-slate-200/70 bg-white/75 px-4 py-5 md:px-6 md:py-6">
                <div class="flex flex-col gap-4 xl:flex-row xl:items-center xl:justify-between">
                    <div>
                        <p class="text-xs uppercase tracking-[0.22em] text-slate-400">Project library</p>
                        <h2 class="mt-1 text-[24px] md:text-[30px] text-slate-800">Manage project entries</h2>
                    </div>

                    <div class="flex flex-wrap items-center gap-3">
                        <div class="rounded-2xl border border-slate-200 bg-white px-4 py-2 text-sm text-slate-500 shadow-sm">
                            {{ number_format($projects->total()) }} records
                        </div>

                        <a href="{{ route('project_backend.create') }}"
                            class="inline-flex items-center gap-2 rounded-2xl bg-[#613bf1] px-5 py-3 text-sm font-semibold text-white shadow-[0_12px_24px_rgba(97,59,241,0.25)] transition hover:bg-[#4f2fe0]">
                            <span class="text-base leading-none">+</span>
                            <span>Add New</span>
                        </a>
                    </div>
                </div>

                <form method="GET" id="filterForm" class="mt-5 flex flex-col gap-3 lg:flex-row lg:items-center">
                    <label class="relative block flex-1 min-w-[260px]">
                        <span class="sr-only">Search projects by name</span>
                        <svg class="pointer-events-none absolute left-4 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="7"></circle>
                            <path d="m20 20-3.5-3.5"></path>
                        </svg>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name..."
                            class="w-full rounded-2xl border border-slate-200 bg-white px-11 py-3 text-sm text-slate-700 shadow-sm placeholder:text-slate-400 focus:border-[#613bf1] focus:outline-none focus:ring-4 focus:ring-[#613bf1]/10"
                            oninput="debouncedSubmitFilter()" />
                    </label>

                    <label class="relative block min-w-[220px]">
                        <span class="sr-only">Filter projects by category</span>
                        <select name="category"
                            class="w-full appearance-none rounded-2xl border border-slate-200 bg-white px-4 py-3 pr-10 text-sm text-slate-700 shadow-sm focus:border-[#613bf1] focus:outline-none focus:ring-4 focus:ring-[#613bf1]/10"
                            onchange="submitFilter()">
                            <option value="">All Categories</option>

                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name_en }}
                                </option>
                            @endforeach
                        </select>
                        <svg class="pointer-events-none absolute right-4 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"
                            viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 11.168l3.71-3.938a.75.75 0 1 1 1.08 1.04l-4.25 4.5a.75.75 0 0 1-1.08 0l-4.25-4.5a.75.75 0 0 1 .02-1.06Z"
                                clip-rule="evenodd" />
                        </svg>
                    </label>

                    @if (request('search') || request('category'))
                        <a href="{{ route('project_backend.index') }}"
                            class="inline-flex items-center justify-center rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm font-medium text-slate-500 shadow-sm transition hover:border-slate-300 hover:text-slate-700">
                            Clear
                        </a>
                    @endif
                </form>
            </div>

            @component('admin.components.alert') @endcomponent

            <div class="overflow-x-auto my-scroll">
                <table class="min-w-[980px] w-full table-fixed text-sm">
                    <thead class="sticky top-0 z-10 bg-[#fafaff]/95 text-slate-500 backdrop-blur">
                        <tr class="border-b border-slate-200/80">
                            <th scope="col" class="px-4 py-4 text-center w-16">#</th>
                            <th scope="col" class="px-4 py-4 text-left w-44">Images</th>
                            <th scope="col" class="px-4 py-4 text-left w-64">Name</th>
                            <th scope="col" class="px-4 py-4 text-left w-44">Category</th>
                            <th scope="col" class="px-4 py-4 text-left w-52">Location</th>
                            <th scope="col" class="px-4 py-4 text-left w-36">Created</th>
                            <th scope="col" class="px-4 py-4 text-left w-[220px]">Action</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100 bg-white/35">
                        @forelse ($projects as $key => $project)
                            <tr class="transition-colors hover:bg-white/75">
                                <td class="px-4 py-4 text-center align-middle">
                                    <span class="inline-flex min-w-8 items-center justify-center rounded-full bg-white px-2 py-1 text-xs font-semibold text-slate-500 shadow-sm">
                                        {{ $projects->firstItem() + $key }}
                                    </span>
                                </td>

                                <td class="px-4 py-4 align-middle">
                                    @php
                                        $images = is_array($project->images ?? null) ? $project->images : [];
                                        $imageCount = count($images);
                                        $firstImage = $imageCount > 0 ? $images[0] : null;
                                    @endphp
                                    <div class="flex items-center gap-3">
                                        @if ($firstImage)
                                            <div class="relative">
                                                <div class="flex h-16 w-16 items-center justify-center overflow-hidden rounded-2xl border border-slate-200 bg-white p-1 shadow-sm">
                                                    <img src="{{ asset('storage/' . $firstImage) }}"
                                                        class="h-full w-full rounded-[12px] object-cover" alt="Project image">
                                                </div>
                                                @if ($imageCount > 1)
                                                    <span class="absolute -right-2 -top-2 rounded-full bg-slate-900 px-2 py-1 text-[10px] font-semibold text-white shadow-lg">
                                                        +{{ $imageCount - 1 }}
                                                    </span>
                                                @endif
                                            </div>
                                        @else
                                            <div class="flex h-16 w-16 items-center justify-center rounded-2xl border border-dashed border-slate-300 bg-white text-[11px] text-slate-400">
                                                No image
                                            </div>
                                        @endif
                                    </div>
                                </td>

                                <td class="px-4 py-4 align-middle">
                                    <div class="max-w-[240px] truncate text-[16px] font-semibold text-slate-700" title="{{ $project->name }}">
                                        {{ $project->name }}
                                    </div>
                                </td>

                                <td class="px-4 py-4 align-middle">
                                    <span class="inline-flex rounded-full bg-white px-3 py-1 text-xs font-medium text-slate-600 shadow-sm">
                                        {{ $project->category->name_en ?? '-' }}
                                    </span>
                                </td>

                                <td class="px-4 py-4 align-middle">
                                    <div class="max-w-[200px] truncate text-slate-600" title="{{ $project->location }}">
                                        {{ $project->location }}
                                    </div>
                                </td>

                                <td class="px-4 py-4 align-middle text-slate-500">
                                    {{ \Carbon\Carbon::parse($project->created_at)->format('d M Y') }}
                                </td>

                                <td class="px-4 py-4 align-middle">
                                    <div class="flex items-center gap-2">
                                        <a class="inline-flex h-10 min-w-[96px] items-center justify-center gap-2 rounded-xl bg-[#613bf1] px-4 text-[12px] font-semibold text-white shadow-[0_10px_18px_rgba(97,59,241,0.18)] transition hover:-translate-y-0.5 hover:bg-[#4f2fe0]"
                                            href="{{ route('project_backend.edit', $project->id) }}" title="Edit project">
                                            <img src="{{ asset('assets/images/icons/edit.svg') }}" alt="" class="h-4 w-4 shrink-0">
                                            <span>Edit</span>
                                        </a>
                                        <a href="{{ route('project_backend.delete', $project->id) }}"
                                            class="inline-flex h-10 min-w-[96px] items-center justify-center gap-2 rounded-xl border border-[#f2caca] bg-[#fff4f4] px-4 text-[12px] font-semibold text-[#c05b5b] shadow-[0_10px_18px_rgba(192,91,91,0.08)] transition hover:-translate-y-0.5 hover:bg-[#ffeaea] hover:text-[#a53f3f]"
                                            aria-label="Delete project"
                                            onclick="event.preventDefault(); deleteRecord('{{ route('project_backend.delete', $project->id) }}')">
                                            <img src="{{ asset('assets/images/icons/trash.svg') }}" alt="" class="h-4 w-4 shrink-0">
                                            <span>Delete</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-16 text-center">
                                    <div class="mx-auto max-w-md">
                                        <div class="text-lg font-semibold text-slate-700">No projects found</div>
                                        <p class="mt-2 text-sm text-slate-500">Try a different search or create a new project entry.</p>
                                        <a href="{{ route('project_backend.create') }}"
                                            class="mt-5 inline-flex items-center gap-2 rounded-2xl bg-[#613bf1] px-5 py-3 text-sm font-semibold text-white shadow-[0_12px_24px_rgba(97,59,241,0.25)] transition hover:bg-[#4f2fe0]">
                                            <span class="text-base leading-none">+</span>
                                            <span>Add New</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4 px-1">
            {{ $projects->withQueryString()->links() }}
        </div>
    </div>

    {{-- ================= JS ================= --}}
    <script>
        let filterTimer;
        function submitFilter() {
            document.getElementById('filterForm').submit();
        }
        function debouncedSubmitFilter() {
            clearTimeout(filterTimer);
            filterTimer = setTimeout(() => {
                document.getElementById('filterForm').submit();
            }, 350);
        }
    </script>

@endsection
