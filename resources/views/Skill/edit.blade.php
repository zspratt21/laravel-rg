@extends('form-base')
@section('header')
    {{ __('Edit Skill: ' . $existing_values['name']) }}
@endsection
@section('content')
    <form action="{{route('skillUpdateInstance', $skill_id)}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="mt-4">
            <x-label class="custom-file-label" for="name">Name</x-label>
            <x-input type="text" name="name" class="block mt-1 w-full" id="name" value="{{$existing_values['name']}}"/>
        </div>
        <div class="mt-4">
            <x-label class="custom-file-label" for="url">Url</x-label>
            <x-input type="text" name="url" class="block mt-1 w-full" id="url" value="{{$existing_values['url']}}"/>
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
