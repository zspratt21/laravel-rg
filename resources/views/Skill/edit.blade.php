@extends('form-base')
@section('head')
    <script type="module">
        $(document).ready(function() {
            $('#select_photo').on('click',function(e) {
                $('#icon').trigger('click');
            });
            $('#icon').on('change',function(e) {
                $('#photo_preview').attr('src', window.URL.createObjectURL(this.files[0]));
                $('#photo_preview').removeClass('hidden');
            });
            $('#remove_photo').on('click',function(e) {
                // Remove photo from model
                $.ajax({
                    url: '{{ route('skillRemoveIcon', $skill_id) }}',
                    type: 'GET',
                    success: function(response) {
                        $('#photo_preview').attr('src', '');
                        $('#photo_preview').addClass('hidden');
                        $('#icon').val(null);
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                        console.log(status);
                        console.log(error);
                    }
                });
            });
        });
    </script>
@endsection
@section('header')
    {{ __('Edit Skill: ' . $existing_values['name']) }}
@endsection
@section('content')
    <form action="{{route('skillUpdate', $skill_id)}}" method="post" enctype="multipart/form-data">
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
            <div class="mt-2">
                @if(!empty($existing_values['icon']))
                    <img height="50" src="{{$existing_values['icon']}}" class="h-20" id="photo_preview">
                @else
                    <img height="50" src="" class="h-20 hidden" id="photo_preview">
                @endif
            </div>
            <x-label class="custom-file-label" for="icon">Icon</x-label>
            <x-input type="file" name="icon" class="hidden" id="icon"/>
            <x-secondary-button class="mt-2 mr-2" type="button" id="select_photo">
                {{ __('Select A New Photo') }}
            </x-secondary-button>
            <x-secondary-button type="button" class="mt-2" id="remove_photo">
                {{ __('Remove Photo') }}
            </x-secondary-button>
        </div>
        <div class="flex items-center justify-end mt-4">
            <x-button class="ml-4">
                {{ __('Update') }}
            </x-button>
        </div>
    </form>
@endsection
