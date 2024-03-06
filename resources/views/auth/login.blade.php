<x-whlayout>
    <x-slot name="title">
        Login
    </x-slot>
    <form method="POST" class="flex flex-col items-start justify-center gap-6 px-5 mx-auto md:w-3/5 lg:px-16 md:px-10">
        @csrf
        <h1 class="font-bold text-neutral-800 text-md md:text-2xl lg:text-3xl">Login</h1>
        <x-form.input name="email" type="email" />
        <x-form.input name="password" type="password" />
        <div class="flex justify-end w-full">
            <button type="submit" class="flex flex-row items-center justify-center w-1/4 p-1 text-xs font-semibold transition duration-500 bg-gray-800 border-4 rounded-lg text-zinc-50 hover:text-neutral-800 md:p-2 lg:text-lg hover:bg-white border-neutral-800">Login</button>
        </div>
        <p class="text-md text-zinc-500">Don't have an account? Click <a href="/register" class="text-zinc-900">SignIn</a>!</p>
    </form>
</x-whlayout>