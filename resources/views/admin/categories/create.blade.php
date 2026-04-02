@extends('admin.layouts.app')
@section('header')
    <h1>Create Category</h1>
@endsection
@section('content')
    <div class="max-w-7xl mx-auto shadow-md rounded-lg p-6 my-2">
        <h2 class="text-2xl font-bold text-[#1e1e1e]">Create Category</h2>
        <form action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @component('admin.components.alert')
            @endcomponent

            <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                <div class="space-y-4">
                    <h1 class="text-[20px] font-[600] text-[#830B00] uppercase">English</h1>
                    <div>
                        <label for="name_en" class="block text-sm font-medium text-[#000] mb-2">Name
                            </label>
                        <input value="{{ old('name_en') }}" name="name_en" id="name_en"
                            class="mt-1 block w-full p-2 border rounded-md text-black text-[12px]"></input>
                        <x-input-error class="mt-2" :messages="$errors->get('content_en')" />
                    </div>
                </div>

                <div class="space-y-4 hidden">
                    <h1 class="text-[20px] font-[600] text-[#830B00] uppercase">Khmer</h1>
                    <div>
                        <label for="name_km" class="block text-sm font-medium text-[#000] mb-2">Name
                            (Khmer)</label>
                        <input value="{{ old('name_km') }}" name="name_km" id="name_km"
                            class="mt-1 block w-full p-2 border rounded-md text-black text-[12px]"></input>
                        <x-input-error class="mt-2" :messages="$errors->get('name_km')" />
                    </div>
                </div>

                <div class="space-y-4 hidden">
                    <h1 class="text-[20px] font-[600] text-[#830B00] uppercase">Chinese</h1>
                    <div>
                        <label for="name_ch" class="block text-sm font-medium text-[#000] mb-2">Name
                            (Chinese)</label>
                        <input value="{{ old('name_ch') }}" name="name_ch" id="name_ch"
                            class="mt-1 block w-full p-2 border rounded-md text-black text-[12px]"></input>
                        <x-input-error class="mt-2" :messages="$errors->get('name_ch')" />
                    </div>
                </div>
            </div>

            <div class="flex justify-between">
                <a href="{{ route('category.index') }}"
                    class="border border-[#4FC9EE] hover:!bg-[#4FC9EE] hover:!text-[#ffffff] px-4 py-1 md:px-6 rounded-[5px] text-[#4FC9EE]">
                    Back
                </a>

                <button type="submit" class="bg-[#4FC9EE] text-white px-4 py-1 md:px-6 rounded-[5px]">Submit</button>
            </div>
        </form>
    </div>
@endsection
