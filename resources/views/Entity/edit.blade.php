@extends('form-base')
@section('head')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <script>

    </script>
@endsection
@section('header')
    {{ __('Edit Entity: ' . $existing_values['name']) }}
@endsection
@section('content')
    <form action="{{route('entityUpdateInstance', $entity_id)}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="mt-4">
            <x-label class="custom-file-label" for="logo">Logo</x-label>
            <x-input type="file" name="logo" class="block mt-1 w- hidden" id="logo"/>
            <div class="mt-2">
                <img height="50" src="{{$existing_values['logo']}}" class="h-20" id="photo_preview">
            </div>
            <x-secondary-button class="mt-2 mr-2" type="button" id="select_photo">
                {{ __('Select A New Photo') }}
            </x-secondary-button>

            <x-secondary-button type="button" class="mt-2" id="remove_photo">
                {{ __('Remove Photo') }}
            </x-secondary-button>
        </div>
        <div class="mt-4">
            <x-label class="custom-file-label" for="name">Name</x-label>
            <x-input type="text" name="name" class="block mt-1 w-full" id="name" value="{{$existing_values['name']}}"/>
        </div>
        <div class="mt-4">
            <x-label class="custom-file-label" for="description">Description</x-label>
            <x-textarea type="textarea" name="description" class="block mt-1 w-full" id="description">@section('initial_value'){{$existing_values['description']}}@endsection</x-textarea>
        </div>
        {{-- @todo implement prefill for image --}}
        {{--        <div class="mt-4">--}}
        {{--            <x-label class="custom-file-label" for="icon">Icon</x-label>--}}
        {{--            <x-input type="file" name="icon" class="block mt-1 w-full" id="icon"/>--}}
        {{--        </div>--}}
        <div class="flex items-center justify-end mt-4">
            <x-button class="ml-4">
                {{ __('Update') }}
            </x-button>
        </div>
    </form>
@endsection
