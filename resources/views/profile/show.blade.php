<x-app-layout>
    <x-slot name="head">
        <script>
            // AJAX form submission
            $(document).ready(function() {
                $('#resumeProfileUpdate').submit(function(e) {
                    e.preventDefault();

                    $.ajax({
                        url: {{ route('resumeProfileUpdate') }},
                        type: 'POST',
                        data: $(this).serialize(),
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
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <x-section-title>
                        <x-slot name="title">{{ __('Resume Profile Information') }}</x-slot>
                        <x-slot name="description">{{ __('Update your account\'s resume profile information and email address.') }}</x-slot>
                    </x-section-title>

                    <div class="mt-5 md:mt-0 md:col-span-2">
                        <div class="px-4 py-5 bg-white dark:bg-gray-800 sm:p-6 shadow sm:rounded-tl-md sm:rounded-tr-md">
                            <div class="">
                                <form action="{{route('resumeProfileUpdate')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mt-4">
                                        <x-label class="custom-file-label" for="address">Address</x-label>
{{--                                        <x-input type="text" name="address" class="block mt-1 w-full" id="address" value="{{$address}}"/>--}}
                                        <x-input type="text" name="address" class="block mt-1 w-full" id="address" value=""/>
                                    </div>
                                    <div class="mt-4">
                                        <x-label class="custom-file-label" for="mobile">Mobile</x-label>
{{--                                        <x-input type="text" name="mobile" class="block mt-1 w-full" id="mobile" value="{{$mobile}}"/>--}}
                                        <x-input type="text" name="mobile" class="block mt-1 w-full" id="mobile" value=""/>
                                    </div>
                                    <div class="mt-4">
                                        <x-label class="custom-file-label" for="introduction">Introduction</x-label>
                                        <x-textarea type="textarea" name="introduction" class="block mt-1 w-full" id="introduction">
                                            @section('initial_value')
{{--                                                {{$introduction}}--}}
                                            @endsection
                                        </x-textarea>
                                    </div>
                                    <div class="mt-4">
                                        <x-label class="custom-file-label" for="cover_photo">Cover Photo</x-label>
                                        <x-input type="file" name="cover_photo" class="block mt-1 w-full" id="cover_photo"/>
                                    </div>
                                    <div class="flex items-center justify-end px-4 py-3 bg-gray-50 dark:bg-gray-800 text-right sm:px-6 shadow sm:rounded-bl-md sm:rounded-br-md">
                                        <x-button>
                                            {{ __('Create') }}
                                        </x-button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

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
