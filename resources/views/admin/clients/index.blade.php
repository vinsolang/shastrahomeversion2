@extends('admin.layouts.app')
@section('header')
    Client
@endsection
@section('content')
    <div class="" x-data="reorderTable()" x-init="initSortable()">
        <div class="my-4 flex items-center gap-4 justify-end">

            <a href="{{ route('client.create') }}"
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

        {{-- <div class="overflow-x-auto px-0 sm:px-2 md:px-4">
            <div class="border border-[#FF3217] max-h-[70vh] overflow-y-auto">
                <table class="min-w-full table-fixed">
                    <thead class="text-black sticky top-0 z-10">
                        <tr>
                            <th class="text-left py-3 px-4 text-xs border-r border-[#FF3217] w-8">Order</th>
                            <th class="text-left py-3 px-4 text-xs border-r border-[#FF3217] w-[200px]">Image</th>
                            <th class="text-left py-3 px-4 text-xs border-r border-[#FF3217] w-[200px]">Action</th>
                        </tr>
                    </thead>
                    <tbody x-ref="tableBody" class="text-gray-700">
                        @foreach ($clients as $index => $client)
                            <tr class="border-t border-[#FF3217] cursor-move" draggable="true" x-bind:data-id="{{ $client->id }}"
                                @dragstart="dragStart($event, {{ $client->id }})" @dragover.prevent
                                @drop="drop($event, {{ $client->id }})">
                                <td class="py-3 px-4 text-xs max-w-[200px] border-r border-[#FF3217]">
                                    <div class="flex items-center h-full w-full">{{ $client->order }}</div>
                                </td>
                                <td class="text-left py-3 px-4 text-[10px] md:text-[12px] border-r border-[#FF3217]">
                                    <div class="flex items-center h-full w-full">
                                        <img src="{{ asset($client->image) }}" alt="" class="w-20 h-12 object-contain object-center">
                                    </div>
                                </td>
                                <td class="py-3 px-4 text-xs border-r border-[#FF3217]">
                                    <div class="flex items-center h-full space-x-2 w-full">
                                        <a href="{{ route('client.delete', $client->id) }}" title="Delete"
                                            onclick="event.preventDefault(); deleteRecord('{{ route('client.delete', $client->id) }}')">
                                            <svg class="w-6 h-6 text-red-500" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="1.5"
                                                    d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('client.edit', $client->id) }}" title="Edit">
                                            <svg class="w-6 h-6 text-green-500 hover:text-green-700 transition"
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="1.5"
                                                    d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div> --}}
        <div class="text-xs text-gray-500 mb-2">Drag the handle to reorder.</div>
        <div class="overflow-x-auto h-full md:max-h-[70vh] overflow-y-auto my-scroll">
            <table class="w-full table-fixed min-w-[680px] md:min-w-full border border-gray-200">
                <thead class="sticky top-0 z-10 bg-white shadow-sm">
                    <tr>
                        <th class="text-left py-3 px-4 text-[12px] text-gray-500 w-16">Move</th>
                        <th class="text-left py-3 px-4 text-[12px] text-gray-500 w-20">Order</th>
                        <th class="text-left py-3 px-4 text-[12px] text-gray-500 w-2/5">Image</th>
                        <th class="text-left py-3 px-4 text-[12px] text-gray-500 w-1/5">Action</th>
                    </tr>
                </thead>

                <tbody x-ref="tableBody"  class="text-gray-700 h-full md:max-h-[40vh] overflow-y-auto">
                    @forelse ($clients as $index => $client)
                        <tr class="border-t border-gray-100 hover:bg-gray-50/60 transition-colors" draggable="true" x-bind:data-id="{{ $client->id }}"
                            @dragstart="dragStart($event, {{ $client->id }})" @dragover.prevent
                            @drop="drop($event, {{ $client->id }})">
                            <td class="text-left py-3 px-4 text-[12px] md:text-[14px]">
                                <span class="drag-handle inline-flex items-center justify-center w-6 h-6 rounded border border-gray-300 text-gray-500 cursor-grab">|||</span>
                            </td>
                            <td class="text-left py-3 px-4 text-[12px] md:text-[14px]">
                                <div class="flex items-center h-full w-full">{{ $client->order }}</div>
                            </td>

                            <td class="text-left py-3 px-4 text-[12px] md:text-[14px]">
                                <img src="{{ asset($client->image) }}" alt=""
                                        class="w-20 h-12 object-contain object-center">
                            </td>


                            <td class="text-left py-3 px-4">
                                <div class="flex items-center gap-2">

                                    <a class="flex items-center gap-2 bg-[#613bf1] text-[#fff] px-3 py-1 text-[12px] rounded-md whitespace-nowrap"
                                        href="{{ route('client.edit', $client->id) }}" title="Edit">
                                        <img src="{{ asset('assets/images/icons/edit.svg') }}" alt=""
                                            class="w-4 h-4">
                                        <p>Edit</p>
                                    </a>

                                    <a href="{{ route('client.delete', $client->id) }}"
                                        class="inline-flex items-center gap-2 text-red-600 hover:text-red-700 text-[12px] px-2 py-1 rounded border border-red-200"
                                        aria-label="Delete client"
                                        onclick="event.preventDefault(); deleteRecord('{{ route('client.delete', $client->id) }}')">
                                        <img src="{{ asset('assets/images/icons/trash.svg') }}" alt="" class="w-4 h-4">
                                        <span>Delete</span>
                                    </a>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="w-full text-center py-6 text-gray-500 text-[14px]">
                                No client logos found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('js')
    <script>
        function reorderTable() {
            return {
                initSortable() {
                    this.$nextTick(() => {
                        let tableBody = this.$refs.tableBody;
                        new Sortable(tableBody, {
                            animation: 150,
                            ghostClass: "bg-gray-100",
                            handle: ".drag-handle",
                            onEnd: async (event) => {
                                let newOrder = [...tableBody.children].map((row, index) => ({
                                    id: row.getAttribute("data-id"),
                                    order: index + 1
                                }));

                                let response = await fetch("{{ route('client.reorder') }}", {
                                    method: "POST",
                                    headers: {
                                        "Content-Type": "application/json",
                                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                                    },
                                    body: JSON.stringify({
                                        newOrder
                                    })
                                });

                                if (response.ok) {
                                    location.reload();
                                } else {
                                    console.error("Failed to reorder.");
                                }
                            }
                        });
                    });
                }
            };
        }
    </script>
@endsection
