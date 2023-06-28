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
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-10">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">Name</th>
                    <th scope="col" class="px-6 py-3">Logo</th>
                    <th scope="col" class="px-6 py-3 text-right">Actions</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($social_media_platforms as $social_media_platform)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{$social_media_platform->name}}</th>
                            <td class="px-4 py-2">
                                @if(!empty($social_media_platform->logo))
                                    <img src="{{$social_media_platform->logo}}" alt="{{$social_media_platform->name}} icon" class="h-10">
                                @else
                                    <span class="px-2 py-2 bg-red-700 text-red-500 rounded">No Logo Uploaded</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{route('editSocial', $social_media_platform->id)}}" class="hover:underline">Edit</a>
                                @if(in_array($social_media_platform->id, $user_links))
                                    <a href="{{route('socialLinkDelete', $social_media_platform->id)}}" class="hover:underline">Unlink</a>
                                @endif
                                <a href="{{route('socialDelete', $social_media_platform->id)}}" class="hover:underline">Delete</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
