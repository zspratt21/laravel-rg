@extends('form-base')
@section('header')
    {{ __('Create New Experience') }}
@endsection
@section('content')
    <form action="{{route('experienceStore')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="mt-4">
            <x-label class="custom-file-label" for="title">Title</x-label>
            <x-input type="text" name="title" class="block mt-1 w-full" id="title"/>
        </div>
        <div class="mt-4">
            <x-label class="custom-file-label" for="description">Description</x-label>
            <x-textarea type="textarea" name="description" class="block mt-1 w-full" id="description"></x-textarea>
        </div>
        <div class="mt-4">
            <x-label class="custom-file-label" for="date_started">Date Started</x-label>
            <x-input type="date" name="date_started" class="block mt-1 w-full" id="date_started"/>
        </div>
        <div class="mt-4">
            <x-label class="custom-file-label" for="date_ended">Date Ended</x-label>
            <x-input type="date" name="date_ended" class="block mt-1 w-full" id="date_ended"/>
        </div>
        <div class="mt-4">
            <x-label for="type">Type</x-label>
            <x-select name="type" class="block mt-1 w-full" id="type">
                @section('options')
                    @foreach ($type_options as $id => $name)
                        <option value="{{$id}}">{{$name}}</option>
                    @endforeach
                @endsection
            </x-select>
        </div>
        <div class="mt-4">
            <x-label for="type">Organisation</x-label>
            <x-select name="entity" class="block mt-1 w-full" id="entity">
                @section('options')
                    @foreach ($entity_options as $id => $name)
                        <option value="{{$id}}">{{$name}}</option>
                    @endforeach
                @overwrite
            </x-select>
        </div>
        <div class="flex items-center justify-end mt-4">
            <x-button class="ml-4">
                {{ __('Create') }}
            </x-button>
        </div>
    </form>
@endsection
