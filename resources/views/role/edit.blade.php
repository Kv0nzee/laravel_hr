<x-layout>
    <x-slot name="title">
        Edit Role
    </x-slot>
    <x-slot name="style">
        <!-- Laravel Mix CSS -->
        @vite('resources/css/app.css')
    </x-slot>    
    <form method="POST" id="roleCreate" action="/role/<?php echo $role->id ?>/update" class="flex flex-col items-start justify-center w-full gap-6 px-5 mx-auto *:lg:px-16 md:px-10">
        @csrf
        @method('PATCH')
        <h1 class="font-bold text-neutral-800 text-md md:text-2xl lg:text-3xl">Edit Role name</h1>
        <div class="w-full md:flex md:gap-x-5">
            <x-form.input label="Name" name="name" :value="$role->name" />
        </div>
        <div class="flex flex-wrap items-start justify-start w-full gap-10">
            @foreach($permissions as $permission)
                <div class="flex items-center min-w-36">
                    <input 
                        id="{{ Str::slug($permission->name) }}-checkbox" 
                        type="checkbox" 
                        name="permissions[]"
                        value="{{ $permission->name }}" 
                        class="w-6 h-6 rounded teal focus:ring-teal-600"
                        @if($role->permissions->contains('name', $permission->name)) checked @endif
                    >
                    <label 
                        for="{{ Str::slug($permission->id) }}-checkbox" 
                        class="text-sm font-medium text-gray-900 ms-2 dark:text-gray-600"
                    >
                        {{ ucfirst(str_replace('_', ' ', $permission->name)) }}
                    </label>
                </div>
            @endforeach
        </div>
        <div class="flex justify-end w-full">
            <button type="submit" class="flex flex-row items-center justify-center w-1/4 p-1 text-xs font-semibold transition duration-500 bg-gray-800 border-4 rounded-lg text-zinc-50 hover:text-neutral-800 md:p-2 lg:text-lg hover:bg-white border-neutral-800">Submit</button>
        </div>
    </form>
</x-layout>
