<x-layout>
    <x-slot name="title">
        Edit Permission
    </x-slot>
    <x-slot name="style">
        <!-- Laravel Mix CSS -->
        @vite('resources/css/app.css')
    </x-slot>    
    <form method="POST" id="permission" action="/permission/<?php echo $permission->id ?>/update" class="flex flex-col items-start justify-center w-full gap-6 px-5 mx-auto *:lg:px-16 md:px-10">
        @csrf
        @method('PATCH')
        <h1 class="font-bold text-neutral-800 text-md md:text-2xl lg:text-3xl">Edit permission name</h1>
        <div class="w-full md:flex md:gap-x-5">
            <x-form.input label="Name" name="name" :value="$permission->name" />
        </div>
        <div class="flex justify-end w-full">
            <button type="submit" class="flex flex-row items-center justify-center w-1/4 p-1 text-xs font-semibold transition duration-500 bg-gray-800 border-4 rounded-lg text-zinc-50 hover:text-neutral-800 md:p-2 lg:text-lg hover:bg-white border-neutral-800">Submit</button>
        </div>
    </form>
</x-layout>
