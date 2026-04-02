@extends('admin.layouts.app')
@section('header')
    <h1>History Page</h1>
@endsection
@section('content')
    <style>
        .my-scroll::-webkit-scrollbar {
            width: 4px;
            height: 4px;;
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
        <div class="my-4 flex items-center gap-4 justify-end">

            <a href="{{ route('history.create') }}"
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
            </a>
        </div>

        @component('admin.components.alert')
        @endcomponent

        <div class="overflow-x-auto h-full md:max-h-[70vh] overflow-y-auto my-scroll">
            <table class="w-full table-fixed min-w-[680px] md:min-w-full border border-gray-200">
                <thead class="sticky top-0 z-10 bg-white shadow-sm">
                    <tr>
                        <th class="text-left py-3 px-4 text-[12px] text-gray-500 w-1/5">Image</th>
                        <th class="text-left py-3 px-4 text-[12px] text-gray-500 w-1/5">Year</th>
                        <th class="text-left py-3 px-4 text-[12px] text-gray-500 w-2/5">Content</th>
                        <th class="text-left py-3 px-4 text-[12px] text-gray-500 w-1/5">Action</th>
                    </tr>
                </thead>

                <tbody class="text-gray-700 h-full md:max-h-[40vh] overflow-y-auto">
                    @forelse ($histories as $history)
                        <tr class="border-t border-gray-100 hover:bg-gray-50/60 transition-colors">
                            {{-- <td class="text-left py-3 px-4 text-[12px] md:text-[14px]">
                                <img src="{{ asset($history->image) }}" alt="" class="w-12 h-12">
                            </td> --}}
                            <td class="py-3 px-4 text-xs align-top">
                                <div class="flex items-center h-full w-full">
                                    @php
                                        $images = json_decode($history->image, true); // decode to array
                                    @endphp
                                    @if (!empty($images) && isset($images[0]))
                                        <img src="{{ asset($images[0]) }}" alt=""
                                            class="w-12 md:w-16 h-auto object-contain object-center">
                                    @else
                                        <span class="text-gray-400 text-xs">No image</span>
                                    @endif
                                </div>
                            </td>
                            <td class="text-left py-3 px-4 text-[12px] md:text-[14px] align-top">
                                {{ $history->year }}
                            </td>
                            <td class="text-left py-3 px-4 text-[12px] md:text-[14px] align-top">
                                <div class="max-w-[560px] line-clamp-3 text-gray-600">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($history->content_en), 220) }}
                                </div>
                            </td>

                            <td class="text-left py-3 px-4 align-top">
                                <div class="flex items-center gap-2">

                                    <a class="flex items-center gap-2 bg-[#613bf1] text-[#fff] px-3 py-1 text-[12px] rounded-md whitespace-nowrap"
                                        href="{{ route('history.edit', $history->id) }}" title="Edit">
                                        <img src="{{ asset('assets/images/icons/edit.svg') }}" alt=""
                                            class="w-4 h-4">
                                        <p>Edit</p>
                                    </a>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-6 text-gray-500 text-[14px]">
                                No history entries found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
