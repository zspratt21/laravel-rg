@extends('form-base')
@section('header')
    {{ __('Create New Social Media Link') }}
@endsection
@section('content')
{{--  @todo consider adding to profile via dynamic ajax  --}}
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
@endsection
