<x-layout>
<x-slot name="title">
    Home
</x-slot>
<x-slot name="style">
  <!-- Laravel Mix CSS -->
  @vite('resources/css/app.css')
</x-slot>

<div class="flex items-center justify-center gap-6">
  <div
    class="relative p-5 overflow-hidden transition-all duration-500 transform bg-gray-100 shadow-xl dark:bg-gray-800 hover:shadow-2xl group rounded-xl">
    <div class="flex items-center gap-4">
      <img src="{{ $user->profile_img ? '/storage/'. $user->profile_img : '/storage/images/avatarlogo.jpg' }}"
      class="object-cover object-center w-32 h-32 transition-all duration-500 delay-500 transform rounded-full group-hover:w-36 group-hover:h-36"
    />
      <div class="transition-all duration-500 transform w-fit">
        <h1 class="font-bold text-gray-600 dark:text-gray-200">
          {{$user->name}}
        </h1>
        <p class="text-gray-400">{{$user->department->title}}</p>
        <a
          class="text-xs text-gray-500 transition-all duration-500 delay-300 transform opacity-5 dark:text-gray-200 group-hover:opacity-100 ">
          {{$user->email}}
        </a>
      </div>
    </div>
    <div class="absolute transition-all duration-500 delay-300 bg-gray-600 rounded-lg group-hover:bottom-1 -bottom-16 dark:bg-gray-100 right-1">
      <div class="flex items-center gap-2 p-1 text-2xl justify-evenlytext-gray-900">
        <a href="/profile/{{$user->name}}"><i class="bi bi-person"></i>Profile</a>
      </div>
    </div>
  </div>
</div>

</x-layout>