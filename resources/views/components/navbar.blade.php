<nav class="fixed top-0 z-50 w-full border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
  <div class="px-3 py-3 lg:px-5 lg:pl-3">
    <div class="flex items-center justify-between">
      <div class="flex items-center justify-start rtl:justify-end">
        <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button" class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
            <span class="sr-only">Open sidebar</span>
            <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
               <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
            </svg>
         </button>
        <a href="/" class="flex ms-2 md:me-24">
          <span class="self-center text-xl font-semibold sm:text-2xl whitespace-nowrap dark:text-white">HR</span>
        </a>
      </div>
      <div class="flex items-center">
        <div class="flex items-center space-x-3 md:order-2 md:space-x-0 rtl:space-x-reverse">
          @auth
          @can('admin')
          <h1>hello</h1>
          @endcan()
          <button type="button" class="flex text-sm bg-gray-800 rounded-full md:me-0 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600" id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown" data-dropdown-placement="bottom">
            <span class="sr-only">Open user menu</span>
            <img class="w-8 h-8 rounded-full" src="{{ auth()->user()->profile_img ? '/storage/'. auth()->user()->profile_img : '/storage/images/avatarlogo.jpg' }}" alt="user photo">
          </button>
          <!-- Dropdown menu -->
          <div class="z-50 hidden my-4 text-base list-none divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600" id="user-dropdown">
            <div class="px-4 py-3">
              <span class="block text-sm text-gray-900 dark:text-white">{{auth()->user()->name}}</span>
              <span class="block text-sm text-gray-500 truncate dark:text-gray-400">{{auth()->user()->email}}</span>
            </div>
            <ul class="py-2" id="usermenubtn" aria-labelledby="user-menu-button">
               <li>
                  <a href="/profile/{{auth()->user()->name}}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Profile</a>
               </li>
               <li>
                  <a href="#" class="block px-4 py-2 text-sm text-gray-700 signout hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">SignOut</a>
               </li>
               {{-- <li>
                 <form action="/logout" method="POST">
                   @csrf
                   <button type="submit" class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">SignOut</button>
                 </form> 
               </li> --}}
            </ul>
          </div>
          @else
          <uL class="flex flex-col p-0 mt-4 font-medium border border-gray-100 rounded-lg md:p-0 bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md: dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
              <li>
                  <a href="/login" class="block py-2 text-gray-900 rounded md:px-3 hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Login</a>
              </li>
              <li>
                  <a href="/register" class="block py-2 text-gray-900 rounded md:px-3 hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Register</a>
              </li>
          </uL>
          @endauth
      </div>
        </div>
    </div>
  </div>
</nav>

<aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full border-r border-gray-200 md:translate-x-0 dark:bg-gray-800 dark:border-gray-700" aria-label="Sidebar">
   <div class="h-full px-3 pb-4 overflow-y-auto dark:bg-gray-800">
      <ul class="space-y-2 font-medium">
         <li>
            <a href="/" class="flex items-center px-4 py-2 text-gray-700 bg-gray-200 dark:text-gray-300 dark:bg-gray-700">
               <span class="sr-only">Home</span>
               <svg class="w-6 h-6 me-2" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 13h18M3 17h18"></path>
               </svg>
               Home
            </a>
         </li>
         @can('view company_setting')
         <li>
            <a href="/company_setting" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white">
               <span class="sr-only">Company Setting</span>
               <i class="bi bi-buildings mr-3 text-lg"></i>
               Company Setting
            </a>
         </li>
         @endcan
         @can('view employees')
         <li>
            <a href="/employee" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white">
               <span class="sr-only">Employees</span>
               <i class="mr-3 text-lg bi bi-people-fill"></i>
               Employees
            </a>
         </li>
         @endcan
         @can('view departments')
         <li>
            <a href="/department" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white">
               <span class="sr-only">Departments</span>
               <svg class="w-6 h-6 me-2" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6m0 5h5m-5 0l-5-5m5 5l5-5"></path>
               </svg>
               Departments
            </a>
         </li>
         @endcan
         @can('view roles')
         <li>
            <a href="/role" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white">
               <span class="sr-only">Roles</span>
               <svg fill="#FFFFFF" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 me-2"  viewBox="0 0 100 100" enable-background="new 0 0 100 100" xml:space="preserve" stroke="#FFFFFF"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M44,63.3c0-3.4,1.1-7.2,2.9-10.2c2.1-3.7,4.5-5.2,6.4-8c3.1-4.6,3.7-11.2,1.7-16.2c-2-5.1-6.7-8.1-12.2-8 s-10,3.5-11.7,8.6c-2,5.6-1.1,12.4,3.4,16.6c1.9,1.7,3.6,4.5,2.6,7.1c-0.9,2.5-3.9,3.6-6,4.6c-4.9,2.1-10.7,5.1-11.7,10.9 c-1,4.7,2.2,9.6,7.4,9.6h21.2c1,0,1.6-1.2,1-2C45.8,72.7,44,68.1,44,63.3z M64,48.3c-8.2,0-15,6.7-15,15s6.7,15,15,15s15-6.7,15-15 S72.3,48.3,64,48.3z M66.6,64.7c-0.4,0-0.9-0.1-1.2-0.2l-5.7,5.7c-0.4,0.4-0.9,0.5-1.2,0.5c-0.5,0-0.9-0.1-1.2-0.5 c-0.6-0.6-0.6-1.7,0-2.5l5.7-5.7c-0.1-0.4-0.2-0.7-0.2-1.2c-0.2-2.6,1.9-5,4.5-5c0.4,0,0.9,0.1,1.2,0.2c0.2,0,0.2,0.2,0.1,0.4 L66,58.9c-0.2,0.1-0.2,0.5,0,0.6l1.7,1.7c0.2,0.2,0.5,0.2,0.7,0l2.5-2.5c0.1-0.1,0.4-0.1,0.4,0.1c0.1,0.4,0.2,0.9,0.2,1.2 C71.6,62.8,69.4,64.9,66.6,64.7z"></path> </g></svg>
               Roles
            </a>
         </li>
         @endcan
         @can('view permissions')
         <li>
            <a href="/permission" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white">
               <span class="sr-only">Permissions</span>
               <svg viewBox="-4.8 -4.8 57.60 57.60" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 me-2" fill="#ffffff" stroke="#ffffff" stroke-width="2.688"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><defs><style>.a{fill:none;stroke:#ffffff;stroke-linecap:round;stroke-linejoin:round;}</style></defs><circle class="a" cx="24" cy="24" r="21.5"></circle><circle class="a" cx="24" cy="24" r="6"></circle><path class="a" d="M29.9994,24.0869H45.5"></path><path class="a" d="M30.1372,11.4169a14,14,0,0,1,4.4607,3.4352"></path><path class="a" d="M34.7246,32.999a14.0006,14.0006,0,0,1-4.5874,3.5841"></path><path class="a" d="M16.3751,12.2586A14,14,0,0,1,25.22,10.0533"></path><path class="a" d="M10.0069,24.44A14,14,0,0,1,12.49,16.03"></path><path class="a" d="M17.6441,36.4741a14,14,0,0,1-6.4338-6.78"></path><path class="a" d="M23.7769,35.6972v9.8016"></path><path class="a" d="M34.7246,32.999l6.5479,3.8037"></path><path class="a" d="M11.21,29.6943,4.94,33.9482"></path><path class="a" d="M12.49,16.03,6.0956,12.097"></path><path class="a" d="M25.22,10.0533l.08-7.5139"></path><path class="a" d="M34.5979,14.8521l6.4589-3.9408"></path></g></svg>
               Permissions
            </a>
         </li>
         @endcan
      </ul>
   </div>
</aside>
