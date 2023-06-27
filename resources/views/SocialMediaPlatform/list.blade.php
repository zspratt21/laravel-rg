<x-app-layout>
    <x-slot name="head">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <script>

        </script>
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('View All Social Media Platforms') }}
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8 flex">
        @foreach($social_media_platforms as $social_media_platform)
            <div class="">
                <h3>{{$social_media_platform->name}}</h3>
                <img height="50" src="{{$social_media_platform->logo}}" class="h-20">
                <a href="{{route('editSocial', $social_media_platform->id)}}">Edit</a>
            </div>
        @endforeach
    </div>
</x-app-layout>
