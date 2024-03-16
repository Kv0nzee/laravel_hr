<x-layout>
  <x-slot name="title">
      Home
  </x-slot>
  <x-slot name="style">
      <!-- Laravel Mix CSS -->
      @vite('resources/css/app.css')
  </x-slot>

  <main class="w-full -mt-20 h-100vh md:-mt-10">
      <section class="relative py-16 bg-gray-200">
         <div class="absolute top-0 w-full bg-center bg-cover h-80"
              style="background-image: url('https://images.unsplash.com/photo-1670974636823-1341d802d5b4?q=80&w=1932&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');">
              <span id="blackOverlay" class="absolute w-full h-full bg-black opacity-50"></span>
          </div>
          <div class="absolute bottom-0 left-0 right-0 top-auto w-full overflow-hidden pointer-events-none h-70"
              style="transform: translateZ(0px)">
              <svg class="absolute bottom-0 overflow-hidden" xmlns="http://www.w3.org/2000/svg"
                  preserveAspectRatio="none" version="1.1" viewBox="0 0 2560 100" x="0" y="0">
                  <polygon class="text-gray-200 fill-current" points="2560 0 2560 100 0 100"></polygon>
              </svg>
          </div>
          <div class="container px-2 mx-auto mt-10 md:px-8">
            <div class="relative flex flex-col w-full min-w-0 mb-6 break-words bg-white rounded-lg shadow-xl">
                <div class="px-6">
                    <div class="flex flex-wrap justify-center">
                        <div class="flex justify-center w-full px-4 lg:w-3/12 lg:order-2">
                            <div class="relative w-full">
                                <img alt="logo" src="{{ $user->profile_img ? '/storage/'. $user->profile_img : '/storage/images/avatarlogo.jpg' }}"
                                    class="absolute w-full -mt-20 align-middle border-none rounded-full shadow-xl object-fit h-44 ">
                            </div>
                        </div>
                        <div class="flex items-center w-full lg:w-4/12 lg:order-3 lg:text-right lg:self-center">
                          <div class="mr-4 text-center">
                            <span class="block text-md font-bold tracking-wide {{ $user->is_present ? 'text-green-400' : 'text-red-400' }}">
                                {{ $user->is_present ? 'Active' : 'Leave' }}
                            </span>
                            <span class="text-sm text-gray-400">Status</span>
                        </div>                        
                          <div class="px-3 py-6 mt-32 sm:mt-0">
                              <button
                                  class="w-auto px-4 py-2 mb-1 text-xs font-bold text-white uppercase transition-all duration-150 ease-linear bg-gray-900 rounded shadow outline-none active:bg-pink-600 hover:shadow-md focus:outline-none sm:mr-2">
                                  <i class="bi bi-telephone-fill"></i> {{$user->phone}}
                              </button>
                          </div>
                        </div>
                        <div class="w-full px-4 lg:w-4/12 lg:order-1">
                            <div class="flex justify-center py-4 pt-8 lg:pt-4">
                                <div class="p-3 mr-4 text-center">
                                    <span class="block font-bold tracking-wide text-gray-600 uppercase text-md">{{$user->department->title}}</span><span
                                        class="text-sm text-gray-400">Department</span>
                                </div>    
                                <div class="p-3 text-center lg:mr-4">
                                    <span class="block font-bold tracking-wide text-gray-600 uppercase text-md">{{$user->gender}}</span><span
                                        class="text-sm text-gray-400">Gender</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <h3 class="mb-2 text-4xl font-semibold leading-normal text-gray-700">
                          <i class="bi bi-person-circle"></i>{{$user->name}}
                        </h3>
                        <div class="mt-0 mb-2 text-sm font-bold leading-normal text-gray-400 uppercase">
                          <i class="bi bi-envelope-at-fill"></i>
                            {{$user->email}}
                        </div>
                        <h1 class="mb-5 font-bold text-gray-800">
                            Role
                          </h1>
                        <p class="text-gray-400">
                            @foreach ($user->roles as $role)
                                <span class="inline-block px-3 py-1 mb-2 mr-3 text-sm font-semibold text-gray-200 bg-gray-900 rounded-full">
                                    {{ $role->name }}
                                </span>
                            @endforeach
                        </p>
                        <div class="justify-center w-full md:flex gap-x-10">
                          <div class="flex flex-col items-start justify-center ">
                              <div class="flex items-center" style="margin-bottom: 30px">
                                  <label  class="pb-1 duration-150 text-end text-md text-zinc-800 text-nowrap" ><i class="bi bi-archive-fill"></i> ID:</label>
                                  <p class="block px-6 pb-1 text-gray-800 bg-transparent border-b-2 border-gray-800 appearance-none text-md">{{ $user->employee_id }}</p>
                              </div>
                              <div class="flex items-center" style="margin-bottom: 30px">
                                  <label  class="pb-1 duration-150 text-end text-md text-zinc-800 text-nowrap" ><i class="bi bi-credit-card-2-front-fill"></i>NRC:</label>
                                  <p class="block px-6 pb-1 text-gray-800 bg-transparent border-b-2 border-gray-800 appearance-none text-md">{{ $user->nrc_number }}</p>
                              </div>
                          </div>
                          
                          <div class="flex flex-col items-start justify-center ">
                            <div class="flex items-center" style="margin-bottom: 30px">
                                  <label  class="pb-1 duration-150 text-end text-md text-zinc-800 text-nowrap" ><i class="bi bi-cake2-fill"></i>Birthday:</label>
                                  <p class="block px-6 pb-1 text-gray-800 bg-transparent border-b-2 border-gray-800 appearance-none text-md">{{ $user->birthday }}</p>
                              </div>
                              
                              <div class="flex items-center " style="margin-bottom: 30px">
                                  <label  class="pb-1 duration-150 text-end text-md text-zinc-800 text-nowrap" ><i class="bi bi-calendar-check-fill"></i>Join Date:</label>
                                  <p class="block px-6 pb-1 text-gray-800 bg-transparent border-b-2 border-gray-800 appearance-none text-md">{{ $user->date_of_join }}</p>
                              </div>
                          </div>
                      </div>
                      {{--beta--}}
                      {{-- <h2>Biometric Authentication</h2>
                        <div class="flex items-center justify-around">
                            <div class="px-3 py-6 mt-32 sm:mt-0">
                                <form id="biometric-register-form">
                                    @csrf 
                                    <button
                                        type="submit"
                                        class="w-auto px-4 py-2 mb-1 text-2xl font-bold text-white uppercase transition-all duration-150 ease-linear bg-gray-900 rounded shadow outline-none active:bg-pink-600 hover:shadow-md focus:outline-none sm:mr-2">
                                        <i class="bi bi-fingerprint"></i> Register with Fingerprint
                                    </button>
                                </form>
                            </div>                            
                        </div>     --}}
                    </div>
                    
                </div>
            </div>
        </div>
      </section>
  </main>

</x-layout>

<script>
    if (Webpass.isUnsupported()) {
   alert('Your device is not secure enough to use this site!');
}
    const register = async (event) => {
    event.preventDefault();
    const formData = new FormData(document.getElementById('biometric-register-form'));
    try {
        const response = await fetch('/webauthn/register/options', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });
        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }
        const data = await response.json();
        console.log('Attestation successful:', data.success);
    } catch (error) {
        console.error('Error during attestation:', error);
    }
}

</script> 
