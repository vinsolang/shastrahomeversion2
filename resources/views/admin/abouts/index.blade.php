@extends('admin.layouts.app')
@section('header')
    <h1>About Us Sections</h1>
@endsection
@section('content')
    <style>
        .my-scroll::-webkit-scrollbar {
            width: 4px;
            height: 4px;
        }

        .my-scroll::-webkit-scrollbar-track {
            background: #fff;
        }

        .my-scroll::-webkit-scrollbar-thumb {
            background: #64748b;
            border-radius: 10px;
        }
    </style>
    <div class="">
        <div class="my-4 flex items-center justify-end">

            {{-- <a href="{{ route('about.create') }}"
                class="bg-[#613bf1] text-[#fff] flex items-center gap-4 px-4 py-2 rounded-[5px] text-[12px] sm:text-[14px]">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#fff">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <path d="M6 12H18M12 6V18" stroke="#fff" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"></path>
                    </g>
                </svg>
                <span class="">Add new</span>
            </a> --}}
        </div>

        @component('admin.components.alert')
        @endcomponent

        <div class="overflow-x-auto h-full md:max-h-[70vh] overflow-y-auto my-scroll">
            <table class="w-full min-w-[680px] md:min-w-full border border-gray-200 table-fixed">
                <thead class="sticky top-0 z-10 bg-white shadow-sm">
                    <tr>
                        <th class="text-left py-3 px-4 text-[12px] text-gray-500 w-1/4">Title</th>
                        <th class="text-left py-3 px-4 text-[12px] text-gray-500 w-[40%]">Content</th>
                        <th class="text-left py-3 px-4 text-[12px] text-gray-500 w-[15%]">PDF</th>
                        <th class="text-left py-3 px-4 text-[12px] text-gray-500 w-[20%]">Action</th>
                    </tr>
                </thead>

                <tbody class="text-gray-700 w-full h-full md:max-h-[40vh] overflow-y-auto">
                    @forelse ($abouts as $about)
                        <tr class="border-t border-gray-100 hover:bg-gray-50/60 transition-colors">
                            <td class="text-left py-3 px-4 text-[12px] md:text-[14px] align-top">
                                <div class="space-y-1">
                                    <div>{{ $about->title_en }}</div>
                                    @if ($about->section_key)
                                        <span class="inline-flex rounded-full bg-slate-100 px-2 py-0.5 text-[10px] font-semibold uppercase tracking-[0.12em] text-slate-500">
                                            {{ str_replace('-', ' ', $about->section_key) }}
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="text-left py-3 px-4 text-[12px] md:text-[14px] align-top">
                                <div class="max-w-[560px] line-clamp-3 text-gray-600">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($about->content1_en), 220) }}
                                </div>
                                @if ($about->section_key === 'founder' && filled($about->content2_en))
                                    <div class="mt-2 text-[11px] font-medium uppercase tracking-[0.08em] text-[#613bf1]">
                                        {{ strip_tags($about->content2_en) }}
                                    </div>
                                @endif
                            </td>
                            <td class="text-left py-3 px-4 text-[12px] md:text-[14px] align-top">
                                @if ($about->pdf_path)
                                    <a href="{{ route('public.media.show', ['path' => $about->pdf_path]) }}" target="_blank" rel="noopener"
                                        class="inline-flex items-center gap-2 rounded-md border border-[#613bf1]/20 bg-[#613bf1]/5 px-3 py-1.5 text-[12px] font-medium text-[#613bf1] hover:bg-[#613bf1]/10">
                                        <span>View PDF</span>
                                    </a>
                                @else
                                    <span class="text-gray-400">No PDF</span>
                                @endif
                            </td>

                            <td class="text-left py-3 px-4 align-top">
                                <div class="flex items-center gap-2">
                                    <a class="flex items-center gap-2 bg-[#613bf1] text-[#fff] px-3 py-1 text-[12px] rounded-md whitespace-nowrap"
                                        href="{{ route('about.edit', $about->id) }}"
                                        title="Edit">
                                        <img src="{{ asset('assets/images/icons/edit.svg') }}" alt=""
                                            class="w-4 h-4">
                                        <p>Edit</p>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-6 text-gray-500 text-[14px]">
                                No about sections found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
