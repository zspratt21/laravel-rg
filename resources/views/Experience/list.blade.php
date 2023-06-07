<x-app-layout>
    <x-slot name="head">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <script>

        </script>
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('View Your Experiences') }}
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8 flex">
        @foreach($experiences as $experience)
            <div class="">
                <h3>{{$experience->title}}</h3>
                <span>{{$experience->entity}}</span>
            </div>
        @endforeach
    </div>
</x-app-layout>
