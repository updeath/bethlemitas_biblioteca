<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Biblioteca-Bethlemitas</title>
</head>
<body class="bg-[#D5DBDB]">
   <div>
      <nav class="bg-[#D5DBDB]  border-b border-gray-200 fixed z-30 w-full">
         <div class="px-3 py-3 lg:px-5 lg:pl-3">
            <div class="flex items-center justify-between">
               <div class="flex items-center justify-start">

                  <button id="toggleSidebarMobile" aria-expanded="true" aria-controls="sidebar" class="lg:hidden mr-2 text-gray-600 hover:text-gray-900 cursor-pointer p-2 hover:bg-gray-100 focus:bg-gray-100 focus:ring-2 focus:ring-gray-100 rounded">
                     <svg id="toggleSidebarMobileHamburger" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                     </svg>
                     <svg id="toggleSidebarMobileClose" class="w-6 h-6 hidden" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                     </svg>
                  </button>

                  <a href="#" class="text-xl font-bold flex items-center lg:ml-2.5">
                     <img src="{{asset('img/R.png')}}" class="h-6 mr-2" alt="Windster Logo">
                     <span class="self-center whitespace-nowrap"> <em>Bethlemitas - Biblioteca</em></span>
                  </a>
               
                  <div class="flex items-center">
                  <button id="toggleSidebarMobileSearch" type="button" class="lg:hidden text-gray-500 hover:text-gray-900 hover:bg-gray-100 p-2 rounded-lg">
                     <span class="sr-only">Search</span>
                     <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                     </svg>
                  </button>
               </div>

                  
                  
               </div>
               <div class="flex items-center">
                  <div class="flex items-center md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
                     <button type="button" class="flex text-sm rounded-full md:me-0 focus:ring-4 focus:ring-gray-300  id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown" data-dropdown-placement="bottom">
                        <span class="sr-only">Open user menu</span>
                        @if (auth()->user() ? auth()->user()->image : '')
                        <img class="w-12 h-11 rounded-full" src="{{ asset(auth()->user() ? auth()->user()->image : '') }}" alt="user photo">
                        @else
                        <img class="w-8 h-8 rounded-full" src="https://placekitten.com/200/200" alt="user photo">
                        @endif
                     </button>
                     <!-- Dropdown menu -->
                     <div class="z-50 hidden my-4 text-base list-none bg-[#D5DBDB] divide-y divide-gray-100 rounded-lg shadow dark:divide-gray-600" id="user-dropdown">
                        <div class="px-4 py-3">
                           <span class="block text-sm text-black-800 italic font-bold">{{Auth::user()->name}} {{Auth::user()->last_name}}</span>
                           <span class="block text-sm  text-black-800 truncate dark:text-gray-400">{{Auth::user()->email}}</span>
                        </div>
                        <ul class="py-2" aria-labelledby="user-menu-button ">

                           <li class="flex items-center hover:bg-[#95A5A6]">
                              <a href="{{ route('profileEdit') }}" class="flex items-center px-4 py-2 text-sm text-black-800 ">
                                 <svg class="6 w-6 mr-2"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                 </svg>
                                 <span>Mi perfil</span>
                              </a>
                           </li>

                           <li class="flex items-center hover:bg-[#95A5A6]">
                              <a href="{{ route('logout') }}" class="flex items-center px-4 py-2 text-sm text-black-800">
                                 <svg class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                 </svg>
                                 <span>Cerrar sesión</span>
                              </a>
                           </li>

                        </ul>
                     </div>
                  </div>
               </div>

            </div>
            </div>
         </div>
      </nav>
           <aside id="sidebar" class="fixed hidden z-20 h-full top-0 left-0 pt-16 flex lg:flex flex-shrink-0 flex-col w-64 transition-width duration-75 " aria-label="Sidebar">
              <div class="relative flex-1 flex flex-col min-h-0 border-r border-gray-200 bg-[#D5DBDB]  pt-0">
                 <div class="flex-1 flex flex-col pt-5 pb-4 overflow-y-auto">
                    <div class="flex-1 px-3 bg-[#D5DBDB] divide-y space-y-1">
                       <ul class="space-y-2 pb-2">
                          <li>
                             <form action="#" method="GET" class="lg:hidden">
                                <label for="mobile-search" class="sr-only">Buscar</label>
                                <div class="relative">
                                   <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                      <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                         <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                                      </svg>
                                   </div>
                                   <input type="text" name="email" id="mobile-search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-cyan-600 focus:ring-cyan-600 block w-full pl-10 p-2.5" placeholder="Buscar">
                                </div>
                             </form>
                          </li>
                          <li>

                           <a href="{{route('home')}}" class="flex items-center px-6 py-2 mt-4 bg-[#95A5A6] text-gray-900 rounded-lg font-medium" >
                              <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                       d="M17 14v6m-3-3h6M6 10h2a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2zm10 0h2a2 2 0 002-2V6a2 2 0 00-2-2h-2a2 2 0 00-2 2v2a2 2 0 002 2zM6 20h2a2 2 0 002-2v-2a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2z">
                                    </path>
                              </svg>
                              <span class="mx-3">Página Principal</span>
                           </a>


                           <a class="flex items-center px-5 py-2 mt-4 hover:bg-[#95A5A6] hover:text-gray-900 hover:rounded-lg font-medium" href="{{route('inventory.create')}}">
                           <svg class="h-6 w-6 "  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />  <polyline points="14 2 14 8 20 8" />  <line x1="12" y1="18" x2="12" y2="12" />  <line x1="9" y1="15" x2="15" y2="15" /></svg>
                              <span class="mx-3">Crear Registro</span>
                           </a>


                           <a class="flex items-center px-5 py-2 mt-4 hover:bg-[#95A5A6] hover:text-gray-900 hover:rounded-lg font-medium" href="{{route('inventory.index')}}">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: rgba(0, 0, 0, 1); transform: ; msFilter:;">
                                 <rect x="2" y="4" width="20" height="16" rx="2" ry="2"></rect>
                                 <path d="M8 2 L8 6 M16 2 L16 6"></path>
                                 <path d="M2 8 L22 8 M2 12 L22 12"></path>
                                 <path d="M8 14 L8 18 M16 14 L16 18"></path>
                              </svg>
                              <span class="mx-3">Inventario</span>
                           </a>


                           <a class="flex items-center px-5 py-2 mt-4 hover:bg-[#95A5A6] hover:text-gray-900 hover:rounded-lg font-medium" href="{{route('donations.index')}}">
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;"><path d="M6.012 18H21V4c0-1.103-.897-2-2-2H6c-1.206 0-3 .799-3 3v14c0 2.201 1.794 3 3 3h15v-2H6.012C5.55 19.988 5 19.806 5 19s.55-.988 1.012-1zM8 9h3V6h2v3h3v2h-3v3h-2v-3H8V9z"></path></svg>
                              <span class="mx-3">Donaciones</span>
                           </a>

                           <a class="flex items-center px-5 py-2 mt-4 hover:bg-[#95A5A6] hover:text-gray-900 hover:rounded-lg font-medium" href="{{route('roleOut.index')}}">
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:; "><path d="m21.484 11.125-9.022-5a1 1 0 0 0-.968-.001l-8.978 4.96a1 1 0 0 0-.003 1.749l9.022 5.04a.995.995 0 0 0 .973.001l8.978-5a1 1 0 0 0-.002-1.749z"></path><path d="M20.515 15.126 12 19.856l-8.515-4.73-.971 1.748 9 5a1 1 0 0 0 .971 0l9-5-.97-1.748zM16 4h6v2h-6z"></path></svg>
                                 <span class="mx-3">Descartes</span>
                           </a>
                           
          
                           
                           </li>
                        </div>
                     </div>
                  </div>
               </div>
           </aside>
           <div id="main-content" class="bg-[#D5DBDB] relative overflow-y-auto lg:ml-64" style="width:80%; position:absolute; top:5rem">
               <main>
                  <div class=" px-9 my-3 max-w-full" >
                     @yield('content')
                  </div>
               </main>
            </div>
         </div>
         <script async defer src="https://buttons.github.io/buttons.js"></script>
         <script src="https://demo.themesberg.com/windster/app.bundle.js"></script>
         <script src="https://cdn.tailwindcss.com"></script>
         <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
   </div>
</body>  
</html>