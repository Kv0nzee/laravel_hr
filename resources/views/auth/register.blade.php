<x-whlayout>
    <x-slot name="title">
        Register
    </x-slot>
    <form method="POST" class="flex flex-col items-start justify-center w-full gap-6 px-5 mx-auto md:w-3/5 lg:px-16 md:px-10">
        @csrf
        <h1 class="font-bold text-neutral-800 text-md md:text-2xl lg:text-3xl">Register</h1>
        <x-form.input name="name" label="Name"  />
        <x-form.input name="email" label="Email" type="email" />
        <x-form.input name="phone" label="Phone Number" type="number" />
        <x-form.input name="password" label="Password" type="password" />
        <x-form.input name="confirm Password" label="Confirm Password" type="password" />
        <div class="flex justify-end w-full">
            <button type="submit" class="flex flex-row items-center justify-center w-1/4 p-1 text-xs font-semibold transition duration-500 bg-gray-800 border-4 rounded-lg text-zinc-50 hover:text-neutral-800 md:p-2 lg:text-lg hover:bg-white border-neutral-800">Register</button>
        </div>
        <p class="text-md text-zinc-500">Already have an account? Click <a href="/login" class="text-zinc-900">Login</a>!</p>
    </form>
</x-whlayout>