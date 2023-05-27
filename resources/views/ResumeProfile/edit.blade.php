@extends('base')
@section('title')
    Edit profile details for your resume
@endsection
@section('head')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
@endsection
@section('content')
    <div class="font-sans text-gray-900 dark:text-gray-100 antialiased">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
            <div class="container mt-5">
                <form action="{{route('resumeProfileUpdate')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mt-4">
                        <x-label class="custom-file-label" for="address">Address</x-label>
                        <x-input type="text" name="address" class="block mt-1 w-full" id="address" value="{{$address}}"/>
                    </div>
                    <div class="mt-4">
                        <x-label class="custom-file-label" for="mobile">Mobile</x-label>
                        <x-input type="text" name="mobile" class="block mt-1 w-full" id="mobile" value="{{$mobile}}"/>
                    </div>
                    <div class="mt-4">
                        <x-label class="custom-file-label" for="introduction">Introduction</x-label>
                        <x-textarea type="textarea" name="introduction" class="block mt-1 w-full" id="introduction">
                            @section('initial_value')
                                {{$introduction}}
                            @endsection
                        </x-textarea>
                    </div>
                    <div class="mt-4">
                        <x-label class="custom-file-label" for="cover_photo">Cover Photo</x-label>
                        <x-input type="file" name="cover_photo" class="block mt-1 w-full" id="cover_photo"/>
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
