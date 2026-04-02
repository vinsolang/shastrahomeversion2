@extends('admin.layouts.app')
@section('header')
    <h1>Edit Category</h1>
@endsection
@section('content')
    <div class="max-w-7xl mx-auto bg-white shadow-md rounded-lg p-6 my-2">
        <h2 class="text-2xl font-bold">Edit Category</h2>
        <form action="{{ route('category.update', $category->id) }}" method="POST"
            enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PATCH')
            @component('admin.components.alert')
            @endcomponent

            <div class="w-full grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="p-0 space-y-4">
                    <h1 class="text-[20px] font-[600] text-[#830B00] uppercase">Name</h1>
                    <div>
                        <label for="name_en" class="block text-sm font-medium text-gray-700">Name</label>
                        <input value="{{ old('name_en', $category->name_en) }}" type="text"
                            name="name_en" id="name_en"
                            class="mt-1 block w-full p-2 border rounded-md text-black text-sm">
                        <x-input-error class="mt-2" :messages="$errors->get('name_en')" />
                    </div>
                </div>

                <div class="p-0 space-y-4 hidden">
                    <h1 class="text-[20px] font-[600] text-[#830B00] uppercase">Name (Khmer)</h1>
                    <div>
                        <label for="name_km" class="block text-sm font-medium text-gray-700">Name</label>
                        <input value="{{ old('name_km', $category->name_km) }}" type="text"
                            name="name_km" id="name_km"
                            class="mt-1 block w-full p-2 border rounded-md text-black text-sm">
                        <x-input-error class="mt-2" :messages="$errors->get('name_km')" />
                    </div>
                </div>

                <div class="p-0 space-y-4 hidden">
                    <h1 class="text-[20px] font-[600] text-[#830B00] uppercase">Name (Chinese)</h1>
                    <div>
                        <label for="name_ch" class="block text-sm font-medium text-gray-700">Name</label>
                        <input value="{{ old('name_ch', $category->name_ch) }}" type="text"
                            name="name_ch" id="name_ch"
                            class="mt-1 block w-full p-2 border rounded-md text-black text-sm">
                        <x-input-error class="mt-2" :messages="$errors->get('name_ch')" />
                    </div>
                </div>
            </div>

            <div class="flex justify-between">
                <a href="{{ route('category.index') }}"
                    class="border border-[#1e1e1e] hover:!bg-[#1e1e1e] hover:!text-[#ffffff] px-4 py-1 md:px-6 rounded-[5px] text-[#1e1e1e]">
                    Back
                </a>

                <button type="submit" class="bg-[#1e1e1e] text-white px-4 py-1 md:px-6 rounded-[5px]">Submit</button>
            </div>
        </form>
    </div>
@endsection
