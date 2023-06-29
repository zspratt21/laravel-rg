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
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-10">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">Title</th>
                    <th scope="col" class="px-6 py-3">Entity</th>
                    <th scope="col" class="px-6 py-3">Type</th>
                    <th scope="col" class="px-6 py-3 text-right">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($experiences as $experience)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{$experience['title']}}</th>
                        <td class="px-4 py-2">{{$experience['entity']}}</td>
                        <td class="px-4 py-2">{{$experience['type']}}</td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{route('experienceEdit', $experience['id'])}}" class="hover:underline">Edit</a>
                            <a href="{{route('experienceDelete', $experience['id'])}}" class="hover:underline">Delete</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
