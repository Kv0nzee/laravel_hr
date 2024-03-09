<x-layout>
    <x-slot name="title">
        Employee Details
    </x-slot>
    
    <div class="flex flex-col items-start justify-center w-full gap-6 px-5 mx-auto lg:px-16 md:px-10">
        <a class="flex items-center px-4 py-2 mb-2 text-sm text-left transition-all bg-gray-600 rounded-lg text-neutral-100 hover:bg-gray-900 " href="{{ URL::previous() }}">Go Back</a>
        <div class="flex items-center justify-between w-full">
            <h1 class="font-bold text-neutral-800 text-md md:text-2xl lg:text-3xl">Employee Details</h1>
            <img  src="{{'/storage/'. $user->profile_img }}" alt="profile image" class=" rounded-full object-contain w-40 h-40 {{ $user->profile_img ? '' : 'hidden' }}">
        </div>        
        <div class="w-full md:flex md:gap-x-5">
            <div class="w-full md:w-1/2">
                <div class="flex items-center w-full" style="margin-bottom: 30px">
                    <label style="width:250px" class="pb-1 duration-150 text-end text-md text-zinc-800 text-nowrap" >Employee ID:</label>
                    <p class="block w-full px-6 pb-1 text-gray-800 bg-transparent border-b-2 border-gray-800 appearance-none text-md">{{ $user->employee_id }}</p>
                </div>
                
                <div class="flex items-center w-full" style="margin-bottom: 30px">
                    <label style="width:250px" class="pb-1 duration-150 text-end text-md text-zinc-800 text-nowrap" >Name:</label>
                    <p class="block w-full px-6 pb-1 text-gray-800 bg-transparent border-b-2 border-gray-800 appearance-none text-md">{{ $user->name }}</p>
                </div>
                
                <div class="flex items-center w-full" style="margin-bottom: 30px">
                    <label style="width:250px" class="pb-1 duration-150 text-end text-md text-zinc-800 text-nowrap" >Email:</label>
                    <p class="block w-full px-6 pb-1 text-gray-800 bg-transparent border-b-2 border-gray-800 appearance-none text-md">{{ $user->email }}</p>
                </div>
                
                <div class="flex items-center w-full" style="margin-bottom: 30px">
                    <label style="width:250px" class="pb-1 duration-150 text-end text-md text-zinc-800 text-nowrap" >Phone Number:</label>
                    <p class="block w-full px-6 pb-1 text-gray-800 bg-transparent border-b-2 border-gray-800 appearance-none text-md">{{ $user->phone }}</p>
                </div>
                
                <div class="flex items-center w-full" style="margin-bottom: 30px">
                    <label style="width:250px" class="pb-1 duration-150 text-end text-md text-zinc-800 text-nowrap" >NRC Number:</label>
                    <p class="block w-full px-6 pb-1 text-gray-800 bg-transparent border-b-2 border-gray-800 appearance-none text-md">{{ $user->nrc_number }}</p>
                </div>
            </div>
            
            <div class="w-full md:w-1/2">
                <div class="flex items-center w-full" style="margin-bottom: 30px">
                    <label style="width:250px" class="pb-1 duration-150 text-end text-md text-zinc-800 text-nowrap" >Gender:</label>
                    <p class="block w-full px-6 pb-1 text-gray-800 bg-transparent border-b-2 border-gray-800 appearance-none text-md">{{ $user->gender }}</p>
                </div>
                
                <div class="flex items-center w-full" style="margin-bottom: 30px">
                    <label style="width:250px" class="pb-1 duration-150 text-end text-md text-zinc-800 text-nowrap" >Birth Date:</label>
                    <p class="block w-full px-6 pb-1 text-gray-800 bg-transparent border-b-2 border-gray-800 appearance-none text-md">{{ $user->birthday }}</p>
                </div>
                
                <div class="flex items-center w-full" style="margin-bottom: 30px">
                    <label style="width:250px" class="pb-1 duration-150 text-end text-md text-zinc-800 text-nowrap" >Department:</label>
                    <p class="block w-full px-6 pb-1 text-gray-800 bg-transparent border-b-2 border-gray-800 appearance-none text-md">{{ $user->department->title }}</p>
                </div>
                
                <div class="flex items-center w-full" style="margin-bottom: 30px">
                    <label style="width:250px" class="pb-1 duration-150 text-end text-md text-zinc-800 text-nowrap" >Employment Status:</label>
                    <p class="block w-full px-6 pb-1 text-gray-800 bg-transparent border-b-2 border-gray-800 appearance-none text-md">{{ $user->is_present }}</p>
                </div>
                
                <div class="flex items-center w-full" style="margin-bottom: 30px">
                    <label style="width:250px" class="pb-1 duration-150 text-end text-md text-zinc-800 text-nowrap" >Date of Join:</label>
                    <p class="block w-full px-6 pb-1 text-gray-800 bg-transparent border-b-2 border-gray-800 appearance-none text-md">{{ $user->date_of_join }}</p>
                </div>
            </div>
        </div>
        
        <div class="flex justify-end w-full mt-6">
            <a href="{{ route('employee.edit', $user->id) }}" class="flex items-center px-4 py-2 text-sm text-left transition-all bg-gray-600 rounded-lg text-neutral-100 hover:bg-gray-900 "><i class="bi bi-pen"></i>Edit</a>
        </div>
    </div>
</x-layout>
