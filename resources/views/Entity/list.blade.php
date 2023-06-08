<x-app-layout>
    <x-slot name="head">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <script>

        </script>
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('View All Entities') }}
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8 flex">
        @foreach($entities as $entity)
            <div class="">
                <h3>{{$entity->name}}</h3>
                <img height="50" src="{{$entity->logo}}" class="h-20">
                <a href="{{route('editEntity', $entity->id)}}">Edit</a>
            </div>
        @endforeach
    </div>
</x-app-layout>
