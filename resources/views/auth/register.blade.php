<x-layout>
    <x-slot name="title">
        Register
    </x-slot>
    <div class="flex flex-col items-start justify-center w-full gap-6 px-5 lg:px-16 md:px-10">
        <h1 class="font-bold text-neutral-800 text-md md:text-2xl lg:text-3xl">Register</h1>
        <x-form.input name="Name" />
        <x-form.input name="Email" type="email" />
        <x-form.input name="Password" type="password" />
        <x-form.input name="Confirm Password" type="password" />
        <div class="flex justify-end w-full">
            <button type="submit" class="flex flex-row items-center justify-center w-1/4 px-2 py-1 text-xs font-semibold text-white transition bg-gray-800 rounded-lg hover:text-neutral-800 md:py-2 md:px-4 lg:text-lg hover:bg-neutral-300">Register</button>
        </div>
    </div>
</x-layout>