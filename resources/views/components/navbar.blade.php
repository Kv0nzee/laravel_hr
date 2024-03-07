<nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
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
            <img class="w-8 h-8 rounded-full" src="/docs/images/people/profile-picture-3.jpg" alt="user photo">
          </button>
          <!-- Dropdown menu -->
          <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600" id="user-dropdown">
            <div class="px-4 py-3">
              <span class="block text-sm text-gray-900 dark:text-white">{{auth()->user()->name}}</span>
              <span class="block text-sm text-gray-500 truncate dark:text-gray-400">{{auth()->user()->email}}</span>
            </div>
            <ul class="py-2" aria-labelledby="user-menu-button">
              <li>
                <form action="/logout" method="POST">
                  @csrf
                  <button type="submit" class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">SignOut</button>
                </form> 
              </li>
              <li>
                  <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Register</a>
                </li>
            </ul>
          </div>
          @else
          <uL class="flex flex-col p-0 mt-4 font-medium border border-gray-100 rounded-lg md:p-0 bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
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

<aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 md:translate-x-0 dark:bg-gray-800 dark:border-gray-700" aria-label="Sidebar">
   <div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-800">
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
         <li>
            <a href="/employee" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white">
               <span class="sr-only">Employees</span>
               <svg class="w-6 h-6 me-2" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h3m8-4h-3m0 12h5m4 4h-3m0-4h3m0 4v3m0-8v-3m0 8l-3 3m3 3l3-3m0 4v3m0-8v-3m0 8h3m0-8h-3m-4-4h3m0 4v3m0-8v-3m0 8l-3 3m3 3l3-3"></path>
               </svg>
               Employees
            </a>
         </li>
         <li>
            <a href="#" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white">
               <span class="sr-only">Team</span>
               <svg class="w-6 h-6 me-2" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6m0 5h5m-5 0l-5-5m5 5l5-5"></path>
               </svg>
               Team
            </a>
         </li>
         <li>
            <a href="#" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white">
               <span class="sr-only">Calendar</span>
               <svg class="w-6 h-6 me-2" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4v5m0 5v5m5-10H3m18 0h-5m5 0v10m-5-10v10m0-10h5m0 5H8"></path>
               </svg>
               Calendar
            </a>
         </li>
         <li>
            <a href="#" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white">
               <span class="sr-only">Documents</span>
               <svg class="w-6 h-6 me-2" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 14l-5-5m0 0l-5 5m5-5V3m0 5h5m-5 0l-5 5m5-5v8m5-8h5m-5 0l-5 5m5-5v8m0 3v5H3v-5m18 5v-5"></path>
               </svg>
               Documents
            </a>
         </li>
      </ul>
   </div>
</aside>
