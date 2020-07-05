
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
                    <a href="/"><li class=" btn-outline-blue-org zoom">Home</li></a>
                    <a href="#"><li class="btn-outline-blue-org zoom">#</li></a>
                    @guest
                    <a href="{{ route('login') }}"><li class="btn-outline-blue-org zoom">Login</li></a>
                    <a href="{{ route('register') }}"><li class="btn-outline-blue-org zoom">Register</li></a>
                    @endguest
                    @auth
                    <a href="#"><li class="btn-outline-blue-org zoom">{{ Auth::user()->name }}</li></a>
                        <a href="#"><li class="btn-outline-blue-org zoom">Logout</li></a>
                    @endauth

                </ul>
            </div>
        </nav>
    </header>
