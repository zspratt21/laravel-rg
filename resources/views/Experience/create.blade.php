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
                <form action="{{route('experienceCreateInstance')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mt-4">
                        <x-label class="custom-file-label" for="title">Title</x-label>
                        <x-input type="text" name="title" class="block mt-1 w-full" id="title"/>
                    </div>
                    <div class="mt-4">
                        <x-label class="custom-file-label" for="description">Description</x-label>
                        <x-textarea type="textarea" name="description" class="block mt-1 w-full" id="description"></x-textarea>
                    </div>
                    {{-- @todo determine best layout for date started and ended --}}
                    {{-- @todo determine best layout for entity reference select --}}
                    <div class="mt-4">
                        <x-label for="type">Type</x-label>
                        <x-select class="block mt-1 w-full">
                            <option value="employment">Employment</option>
                            <option value="education">Education</option>
                        </x-select>
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
