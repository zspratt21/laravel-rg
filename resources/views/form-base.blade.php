<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="font-sans text-gray-900 dark:text-gray-100 antialiased">
                    <div class="w-full mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
                        <div class="container mt-5">
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
