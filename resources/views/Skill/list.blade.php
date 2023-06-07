<x-app-layout>
    <x-slot name="head">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <script>

        </script>
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('View All Skills') }}
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8 flex">
        @foreach($skills as $skill)
            <div class="">
                <h3>{{$skill->name}}</h3>
                <img height="50" src="{{$skill->icon}}" class="h-20">
                <a href="{{route('skillUpdateInstance', $skill->id)}}">Edit</a>
                <a href="{{route('skillCreateLink', $skill->id)}}">Link</a>
            </div>
        @endforeach
    </div>
</x-app-layout>
