<nav x-data="{ open: false }" class="flex  items-center justify-between flex-wrap bg-teal-500 p-6">
    <div class=" ml-10 flex items-center flex-shrink-0 text-white mr-6">
       <div class="flex" ><a href="{{route('dashboard')}}" class="flex"> <svg class="fill-current h-8 w-8 mr-2" width="54" height="54" viewBox="0 0 54 54"
             xmlns="http://www.w3.org/2000/svg">
            <path
                d="M13.5 22.1c1.8-7.2 6.3-10.8 13.5-10.8 10.8 0 12.15 8.1 17.55 9.45 3.6.9 6.75-.45 9.45-4.05-1.8 7.2-6.3 10.8-13.5 10.8-10.8 0-12.15-8.1-17.55-9.45-3.6-.9-6.75.45-9.45 4.05zM0 38.3c1.8-7.2 6.3-10.8 13.5-10.8 10.8 0 12.15 8.1 17.55 9.45 3.6.9 6.75-.45 9.45-4.05-1.8 7.2-6.3 10.8-13.5 10.8-10.8 0-12.15-8.1-17.55-9.45-3.6-.9-6.75.45-9.45 4.05z"/>
        </svg>
        <span class="font-semibold text-xl tracking-tight">Billing Software</span>
           </a>
       </div>
        <div class="ml-10"> <a href="{{route('users.index')}}">Users</a></div>
        <div class="ml-10"> <a href="{{route('companies.index')}}">Companies</a></div>
        <div class="ml-10"> <a href="{{route('products.index')}}">Products</a></div>
        <div class="ml-10"> <a href="{{route('categories.index')}}">Categories/Subcategories</a></div>


    </div>
    <div class="block lg:hidden">
        <button
            class="flex items-center px-3 py-2 border rounded text-teal-200 border-teal-400 hover:text-white hover:border-white">
            <svg class="fill-current h-3 w-3" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><title>Menu</title>
                <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"/>
            </svg>
        </button>
    </div>
    <div class="w-full block flex-grow lg:flex mr-10 lg:items-center lg:w-auto">
        <div class="text-sm lg:flex-grow text-white ">
        </div>

        @if(Auth::user())
            <div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <a href="route('logout')"
                       class="inline-block mr-10 mr-3 text-sm px-4 py-2 leading-none border rounded text-white border-white hover:border-transparent hover:text-teal-500 hover:bg-white mt-4 lg:mt-0"
                                     onclick="event.preventDefault();
                                                this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </a>
                </form>
            </div>
        @else
            <div>
                <a href="{{route('login')}}"
                   class=" mr-10 inline-block mr-3 text-sm px-4 py-2 leading-none border rounded text-white border-white hover:border-transparent hover:text-teal-500 hover:bg-white mt-4 lg:mt-0">Login</a>
            </div>
        @endif
    </div>
</nav>

