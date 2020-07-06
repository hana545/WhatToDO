
    <header>
        <nav>
            <div class="menu-icon">
                <i class="fa fa-2x fa-bars" aria-hidden="true"></i>
            </div>
            <div class="logo">
                <a href="/"><img src="images/logo/logo-bw.png" style="height: 80%; width: 200px"></a>
            </div>
            <div class="menu">
                <ul>
                    <a href={{route('home')}}><li class=" btn-outline-blue-org zoom">Home</li></a>
                    <a href="{{route('search')}}"><li class="btn-outline-blue-org zoom">Search</li></a>
                    @auth <a href="#"><li class="btn-outline-blue-org zoom">Add object</li></a> @endauth
                    @if (Auth::check() && Auth::user()->type == true)
                        <a href="#"><li class="btn-outline-blue-org zoom">Confirm objects</li></a>
                    @endif
                    @guest
                        <a class="" href="{{ route('login') }}">
                            <li class=" btn-outline-blue-org zoom">{{ __('Login') }}</li>
                        </a>
                        @if (Route::has('register'))
                            <a class="" href="{{ route('register') }}">
                                <li class="btn-outline-blue-org zoom">{{ __('Register') }}</li>
                            </a>
                        @endif
                    @else
                        <a href="{{route('user')}}" >
                            <li class="btn-outline-blue-org zoom light-groove-border"> {{ Auth::user()->name }}</li>
                        </a>
                        <a href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            <li class="btn-outline-blue-org zoom"> {{ __('Logout') }}</li>

                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    @endguest


                </ul>
            </div>
        </nav>
    </header>
