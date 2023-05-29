@extends('base')
@section('title')
    Create a new social media platform
@endsection
@section('content')
    <div class="font-sans text-gray-900 dark:text-gray-100 antialiased">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
            <div class="container mt-5">
                <form action="{{route('socialCreateInstance')}}" method="post" enctype="multipart/form-data">
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
            </div>
        </div>
    </div>
@endsection
