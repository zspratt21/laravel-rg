@extends('form-base')
@section('head')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <script>
        console.log('hello from experience edit template!');
        console.log({{$experience_id}});
        $(document).ready(function() {
            $('#experienceUpdate').submit(function(e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                let formData = new FormData(this);
                $.ajax({
                    _token: "{{ csrf_token() }}",
                    url: '{{ route('experienceUpdateInstance', ['experience_id' => $experience_id]) }}',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        // Handle the response from the server
                        console.log('noice');
                    },
                    error: function(xhr, status, error) {
                        // Handle error
                        console.log(xhr.responseText);
                    }
                });
            });
            $(document).on('change', '.milestone-image', function (e) {
                $(this).closest('.milestone-form').find('.photo-preview').attr('src', window.URL.createObjectURL(this.files[0]));
                $(this).closest('.milestone-form').find('.photo-preview').removeClass('hidden');
            });
            $(document).on('click', '.select-photo', function (e) {
                $(this).closest('.milestone-form').find('.milestone-image').trigger('click');
            });
            $(document).on('click', '.remove-photo', function (e) {
                $(this).closest('.milestone-form').find('.photo-preview').attr('src', '');
                $(this).closest('.milestone-form').find('.photo-preview').addClass('hidden');
                console.log($(this).closest('.milestone-form').find('.milestone-image').val());
                $(this).closest('.milestone-form').find('.milestone-image').val(null);
                console.log($(this).closest('.milestone-form').find('.milestone-image').val());
                if ($(this).closest('.milestone-form').hasClass('milestone-edit') === true) {
                    console.log('id for image remove')
                    console.log($(this).closest('.milestone-form').find('.milestone-id').val());
                    $.ajax({
                        url: '/edit/milestone/' + $(this).closest('.milestone-form').find('.milestone-id').val() + '/remove-image',
                        type: 'GET',
                        success: function(response) {
                            console.log(response);
                        },
                        error: function(xhr, status, error) {
                            // Handle error
                            console.log(xhr.responseText);
                        }
                    });
                }
            });
            $(document).on('submit', '.milestone-edit', function (e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                let formData = new FormData(this);
                console.log(formData.get('id'));
                $.ajax({
                    _token: "{{ csrf_token() }}",
                    url: '/edit/milestone/'+formData.get('id')+'/submit',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        // Handle the response from the server
                        console.log('edit blade line 63');
                        console.log(response);
                    },
                    error: function(xhr, status, error) {
                        // Handle error
                        console.log(xhr.responseText);
                    }
                });
            });

            $(document).on('submit', '.milestone-create', function (e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                let formData = new FormData(this);
                $.ajax({
                    _token: "{{ csrf_token() }}",
                    url: '{{ route('milestoneCreateInstance', ['experience_id' => $experience_id]) }}',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        // Handle the response from the server
                        console.log('edit blade line 52');
                        console.log(response.milestone.id);
                        $.ajax({
                            url: '/edit/milestone/'+response.milestone.id,
                            type: 'GET',
                            contentType: false,
                            processData: false,
                            success: function(response) {
                                $('#milestones').append(response.html);
                                console.log($(this));
                            },
                            error: function(xhr, status, error) {
                                // Handle error
                                console.log(xhr.responseText);
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        // Handle error
                        console.log(xhr.responseText);
                    }
                });
            });
            $('#add-milestone').on('click',function(e) {
                $.ajax({
                    url: '{{ route('createMilestone', ['experience_id' => $experience_id]) }}',
                    type: 'GET',
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $('#milestones').append(response.html);
                    },
                    error: function(xhr, status, error) {
                        // Handle error
                        console.log(xhr.responseText);
                    }
                });
            });
            $('#update').on('click',function(e) {
                $('#experienceUpdate').trigger('submit');
                $('.milestone-create').each(function(){
                    $(this).trigger('submit');
                });
                $('.milestone-edit').each(function(){
                    $(this).trigger('submit');
                });
            });
        });
    </script>
@endsection
@section('header')
    {{ __('Edit Experience: '.$existing_values['title']) }}
@endsection
@section('content')
    <form action="{{route('experienceUpdateInstance', ['experience_id' => $experience_id])}}" method="post" enctype="multipart/form-data" id="experienceUpdate">
        @csrf
        <div class="mt-4">
            <x-label class="custom-file-label" for="title">Title</x-label>
            <x-input type="text" name="title" class="block mt-1 w-full" id="title" value="{{$existing_values['title']}}"/>
        </div>
        <div class="mt-4">
            <x-label class="custom-file-label" for="description">Description</x-label>
            <x-textarea type="textarea" name="description" class="block mt-1 w-full" id="description">@section('initial_value'){{$existing_values['description']}}@endsection</x-textarea>
        </div>
        <div class="mt-4">
            <x-label class="custom-file-label" for="date_started">Date Started</x-label>
            <x-input type="date" name="date_started" class="block mt-1 w-full" id="date_started" value="{{$existing_values['date_started']}}"/>
        </div>
        <div class="mt-4">
            <x-label class="custom-file-label" for="date_ended">Date Ended</x-label>
            <x-input type="date" name="date_ended" class="block mt-1 w-full" id="date_ended" value="{{$existing_values['date_ended']}}"/>
        </div>
        <div class="mt-4">
            <x-label for="type">Type</x-label>
            <x-select name="type" class="block mt-1 w-full" id="type">
                @section('options')
                    @foreach ($type_options as $id => $name)
                        <option value="{{$id}}" @if($id == $existing_values['type'])
                            selected
                            @endif>{{$name}}</option>
                    @endforeach
                @endsection
            </x-select>
        </div>
        <div class="mt-4">
            <x-label for="type">Organisation</x-label>
            <x-select name="entity" class="block mt-1 w-full" id="entity">
                @section('options')
                    @foreach ($entity_options as $id => $name)
                        <option value="{{$id}}"
                                @if($id == $existing_values['entity'])
                                selected
                            @endif
                        >{{$name}}</option>
                    @endforeach
                @overwrite
            </x-select>
        </div>
        <input type="submit" class="hidden">
    </form>
    <div id="milestones">
        @foreach($milestone_edit_forms as $milestone_edit_form)
            {!!$milestone_edit_form!!}
        @endforeach
    </div>
    <div class="flex items-center justify-end mt-4">
        <x-button class="ml-4" id="add-milestone">
            {{ __('Add Milestone') }}
        </x-button>
        <x-button class="ml-4" id="update">
            {{ __('Update') }}
        </x-button>
    </div>
@endsection
