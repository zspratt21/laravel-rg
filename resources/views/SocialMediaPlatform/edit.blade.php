@extends('form-base')
@section('head')
    <script type="module">
        $(document).ready(function() {
            $('#select_photo').on('click',function(e) {
                $('#logo').trigger('click');
            });
            $('#logo').on('change',function(e) {
                $('#photo_preview').attr('src', window.URL.createObjectURL(this.files[0]));
                $('#photo_preview').removeClass('hidden');
            });
            $('#remove_photo').on('click',function(e) {
                // Remove photo from model
                $.ajax({
                    url: '{{ route('socialRemoveLogo', $social_id) }}',
                    type: 'GET',
                    success: function(response) {
                        // Remove photo from input
                        // @ jquery empty value
                        // Remove photo from preview img tag
                        $('#photo_preview').attr('src', '');
                        $('#photo_preview').addClass('hidden');
                    },
                    error: function(xhr, status, error) {
                        // Handle error
                        console.log(xhr.responseText);
                    }
                });
            });
        });
    </script>
@endsection
@section('header')
    {{ __('Edit Social Media Platform: ' . $existing_values['name']) }}
@endsection
@section('content')
    <form action="{{route('socialUpdateInstance', $social_id)}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="mt-4">
            <x-label class="custom-file-label" for="name">Name</x-label>
            <x-input type="text" name="name" class="block mt-1 w-full" id="name" value="{{$existing_values['name']}}"/>
        </div>
        <div class="mt-4">
            <div class="mt-2">
                @if(!empty($existing_values['logo']))
                    <img height="50" src="{{$existing_values['logo']}}" class="h-20" id="photo_preview">
                @else
                    <img height="50" src="" class="h-20 hidden" id="photo_preview">
                @endif
            </div>
            <x-label class="custom-file-label" for="logo">Logo</x-label>
            <x-input type="file" name="logo" class="hidden" id="logo"/>
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
