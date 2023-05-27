@extends('base')
@section('title')
    Create a new skill
@endsection
@section('head')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
@endsection
@section('content')
    <div class="font-sans text-gray-900 dark:text-gray-100 antialiased">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
            <div class="container mt-5">
                <form action="{{route('skillCreateInstance')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mt-4">
                        <x-label class="custom-file-label" for="name">Name</x-label>
                        <x-input type="text" name="name" class="block mt-1 w-full" id="name"/>
                    </div>
                    <div class="mt-4">
                        <x-label class="custom-file-label" for="url">Url</x-label>
                        <x-input type="text" name="url" class="block mt-1 w-full" id="url"/>
                    </div>
                    <div class="mt-4">
                        <x-label class="custom-file-label" for="description">Description</x-label>
                        <x-textarea type="textarea" name="description" class="block mt-1 w-full" id="description"></x-textarea>
                    </div>
                    <div class="mt-4">
                        <x-label class="custom-file-label" for="icon">Icon</x-label>
                        <x-input type="file" name="icon" class="block mt-1 w-full" id="icon"/>
                    </div>
                    <div class="flex items-center justify-end mt-4">
                        <x-button class="ml-4">
                            {{ __('Create') }}
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
