@extends('base')
@section('title')
    Create a new social media link
@endsection
@section('content')
    <div class="font-sans text-gray-900 dark:text-gray-100 antialiased">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
            <div class="container mt-5">
                <form action="{{route('socialLinkCreateInstance')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mt-4">
                        <x-label class="custom-file-label" for="title">Url</x-label>
                        <x-input type="text" name="url" class="block mt-1 w-full" id="url"/>
                    </div>
                    <div class="mt-4">
                        <x-label for="type">Platforms</x-label>
                        <x-select name="social_media_platform" class="block mt-1 w-full" id="social_media_platform">
                            @section('options')
                                @foreach ($platform_options as $id => $name)
                                    <option value="{{$id}}">{{$name}}</option>
                                @endforeach
                            @endsection
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
