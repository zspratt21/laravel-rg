<x-app-layout>
    <x-slot name="head">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <script>
            // AJAX form submission
            $(document).ready(function() {
                $.ajax({
                    url: '{{ route('resumeProfileGet') }}',
                    type: 'GET',
                    success: function(response) {
                        // Handle the response from the server
                        console.log(response);
                        console.log(response.cover_photo);
                        $('#address').val(response.address);
                        $('#mobile').val(response.mobile);
                        $('#introduction').val(response.introduction);
                        console.log(response.cover_photo);
                        if($.type(response.cover_photo) === 'string') {
                            $('#photo_preview').attr('src', response.cover_photo);
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle error
                        console.log(xhr.responseText);
                    }
                });
                $('#select_photo').on('click',function(e) {
                    $('#cover_photo').trigger('click');
                });
                $('#cover_photo').on('change',function(e) {
                    $('#photo_preview').attr('src', window.URL.createObjectURL(this.files[0]));
                });
                $('#remove_photo').on('click',function(e) {
                    // Remove photo from model
                    $.ajax({
                        url: '{{ route('resumeProfileRemoveCoverPhoto') }}',
                        type: 'GET',
                        success: function(response) {
                            // Handle the response from the server
                            console.log(response);
                        },
                        error: function(xhr, status, error) {
                            // Handle error
                            console.log(xhr.responseText);
                        }
                    });
                    // Remove photo from input

                    // Remove photo from preview img tag
                    $('#photo_preview').attr('src', '');
                });
                $('#resumeProfileUpdate').submit(function(e) {
                    e.preventDefault();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    let formData = new FormData(this);
                    $.ajax({
                        _token: "{{ csrf_token() }}",
                        url: '{{ route('resumeProfileUpdate') }}',
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            // Handle the response from the server
                            console.log(response);
                        },
                        error: function(xhr, status, error) {
                            // Handle error
                            console.log(xhr.responseText);
                        }
                    });
                });
            });
        </script>
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                @livewire('profile.update-profile-information-form')

                <x-section-border />
                <x-form-section submit="resumeProfileUpdate">
                    <x-slot name="form_attributes">id="resumeProfileUpdate" enctype="multipart/form-data"</x-slot>
                    <x-slot name="title">
                        {{ __('Resume Profile Information') }}
                    </x-slot>
                    <x-slot name="description">
                        {{ __('Update your account\'s resume profile information.') }}
                    </x-slot>
                    <x-slot name="form">
                        <div class="col-span-6 sm:col-span-6">
                            <x-label class="custom-file-label" for="introduction">Introduction</x-label>
                            <x-textarea type="textarea" name="introduction" class="block mt-1 w-full" id="introduction" rows="10"></x-textarea>
                        </div>
                        <div class="col-span-6 sm:col-span-6">
                            <x-label class="custom-file-label" for="cover_photo">Cover Photo</x-label>
                            <x-input type="file" name="cover_photo" class="block mt-1 w- hidden" id="cover_photo"/>
                            <div class="mt-2">
                                <img src="" id="photo_preview">
                            </div>
                            <x-secondary-button class="mt-2 mr-2" type="button" id="select_photo">
                                {{ __('Select A New Photo') }}
                            </x-secondary-button>

                            <x-secondary-button type="button" class="mt-2" id="remove_photo">
                                {{ __('Remove Photo') }}
                            </x-secondary-button>
                        </div>
                        <div class="col-span-6 sm:col-span-4">
                            <x-label class="custom-file-label" for="address">Address</x-label>
                            <x-input type="text" name="address" class="block mt-1 w-full" id="address" value=""/>
                        </div>
                        <div class="col-span-6 sm:col-span-4">
                            <x-label class="custom-file-label" for="mobile">Mobile</x-label>
                            <x-input type="text" name="mobile" class="block mt-1 w-full" id="mobile" value=""/>
                        </div>
                    </x-slot>
                    <x-slot name="actions">
{{--                        <x-action-message class="mr-3" on="saved">--}}
{{--                            {{ __('Saved.') }}--}}
{{--                        </x-action-message>--}}

                        <x-button>
                            {{ __('Save') }}
                        </x-button>
                    </x-slot>
                </x-form-section>

                <x-section-border />
            @endif

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                <div class="mt-10 sm:mt-0">
                    @livewire('profile.update-password-form')
                </div>

                <x-section-border />
            @endif

            @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                <div class="mt-10 sm:mt-0">
                    @livewire('profile.two-factor-authentication-form')
                </div>

                <x-section-border />
            @endif

            <div class="mt-10 sm:mt-0">
                @livewire('profile.logout-other-browser-sessions-form')
            </div>

            @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                <x-section-border />

                <div class="mt-10 sm:mt-0">
                    @livewire('profile.delete-user-form')
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
