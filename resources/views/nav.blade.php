<nav class="nav navbar navbar-expand-md navbar-dark p-3 fixed-top ">
    <div class="container-fluid mr-3">
        <a href="/"><img src="{{ asset('images/logo/logo-bw.png') }}" style="height: 80%; width: 200px"></a>

        <button v-on:click="CheckSmallNav()" class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto text-left">
                <li class="nav-item p-2">
                    <a href="{{route('home')}}" class="nav-link">Home</a>
                </li>
                <li class="nav-item p-2">
                    <a href="{{route('search')}}" class="nav-link">Search</a>
                </li>
                @if (Auth::check() && Auth::user()->type == true)
                    <li class="nav-item dropdown p-2">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown1" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Options
                        </a>
                        <div class="dropdown-menu bg-black" aria-labelledby="navbarDropdown1">
                            <a class="dropdown-item btn-outline-blue "  href="{{route('add_object')}}">Add place</a>
                            <a class="dropdown-item btn-outline-blue" href="/approve">Confirm places</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item btn-outline-blue"  href="{{route('add_tag')}}">Tags</a>
                            <a class="dropdown-item btn-outline-blue"  href="{{route('add_category')}}">Category</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item btn-outline-blue"  href="{{route('manageAdminsUsers')}}">Manage admins/users</a>
                        </div>
                    </li>
                @elseif (Auth::check())
                    <li class="nav-item p-2">
                        <a class="nav-link @if(Auth::user()->suspended == true) disabled @endif " href="{{route('add_object')}}" >Add place</a>
                    </li>
                @endif
                @guest
                    <li class="nav-item p-2">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item p-2">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown p-2">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown2" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ Auth::user()->name }}
                        </a>
                        <div class="dropdown-menu bg-black" aria-labelledby="navbarDropdown2">

                            <a class="dropdown-item btn-outline-blue" href="{{route('user')}}">User profile</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item btn-outline-blue" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
