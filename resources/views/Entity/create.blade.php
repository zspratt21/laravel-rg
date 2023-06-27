@extends('form-base')
@section('header')
    {{ __('Create New Entity') }}
@endsection
@section('content')
    <form action="{{route('entityCreateInstance')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="mt-4">
            <x-label class="custom-file-label" for="name">Name</x-label>
            <x-input type="text" name="name" class="block mt-1 w-full" id="name"/>
        </div>
        <div class="mt-4">
            <x-label class="custom-file-label" for="logo">Logo</x-label>
            <x-input type="file" name="logo" class="block mt-1 w-full" id="logo"/>
        </div>
        <div class="flex items-center justify-end mt-4">
            <x-button class="ml-4">
                {{ __('Create') }}
            </x-button>
        </div>
    </form>
@endsection
