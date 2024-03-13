<x-layout>
    <x-slot name="title">
        Company Setting
    </x-slot>
    <x-slot name="style">
        <!-- Laravel Mix CSS -->
        @vite('resources/css/app.css')
    </x-slot>
    <div class="flex items-center justify-center w-full gap-6">
        <div
            class="relative min-w-full p-5 overflow-hidden transition-all duration-500 transform bg-gray-100 shadow-xl md:w-1/2 dark:bg-gray-800 hover:shadow-2xl group rounded-xl">
            <div class="flex flex-wrap items-center gap-4">
                <div class="transition-all duration-500 transform w-fit">
                    <h1 class="font-bold text-gray-600 dark:text-gray-200">
                        {{ $companySetting->company_name }}
                    </h1>
                    <a
                        class="text-xs text-gray-500  dark:text-gray-200 ">
                        {{ $companySetting->email }}
                    </a>
                </div>
            </div>
            <div class="transition-all duration-500 transform w-fit">
                <p class="text-gray-400">{{ $companySetting->company_address }}</p>
                <p class="text-gray-400">
                    Office Hours: {{ $companySetting->office_start_time }} - {{ $companySetting->office_end_time }}
                </p>
                <p class="text-gray-400">
                    Break Time: {{ $companySetting->break_start_time }} - {{ $companySetting->break_end_time }}
                </p>
            </div>

            <div class="absolute transition-all duration-500 delay-300 bg-gray-600 rounded-lg group-hover:bottom-1 -bottom-16 dark:bg-gray-100 right-1">
                <div class="flex items-center gap-2 p-1 text-2xl justify-evenlytext-gray-900">
                    <a href="/company_setting/{{$companySetting->id}}/edit"><i class="bi bi-buildings  text-lg"></i>Edit Company Setting</a>
                </div>
            </div>
        </div>
    </div>
</x-layout>
