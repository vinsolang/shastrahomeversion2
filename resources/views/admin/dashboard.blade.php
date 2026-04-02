@extends('admin.layouts.app')
@section('header')
    Dashboard
@endsection
@section('content')
    <div class="w-full h-[80vh]">
        <div class="flex flex-col w-full h-full items-center justify-center gap-4">
            <img src="{{ asset("assets/logo/Logo_not_text.png") }}" alt="" class="w-40 h-auto" />
            <h1 class="text-[#000] text-center text-[30px] font-[600]">Welcome to <span class="text-[#1e1e1e]">Shastra</span>  <br> Dashboard</h1>
        </div>
    </div>
@endsection
