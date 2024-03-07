@props(['name', 'value' => '', 'type' => 'text', 'label', 'required' => true])

<x-form.inputWrapper>
    <input
        value="{{ old($name, $value) }}"
        type="{{ $type }}"
        id="{{ $name }}"
        name="{{ $name }}"
        class="block w-full px-6 pt-6 pb-1 text-gray-800 appearance-none text-md bg-transparent border-b-2 border-gray-800 focus:outline-none focus:ring-0 peer @error($name) border-red-500 @enderror"
        placeholder=" "
        @if($required) required @endif
    />
    <label
        for="{{ $name }}"
        class="absolute text-md text-zinc-800 duration-150 transform -translate-y-3 scale-75 top-4 z-10 origin-[0] peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-3"
    >{{ $label }}</label>
    @error($name)
        <p class="text-red-700">{{ $message }}</p>
    @enderror
</x-form.inputWrapper>
