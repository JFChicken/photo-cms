<nav class="">

        <a class="" href="{{ url('/') }}">
            {{ config('app.name', 'Photo CMS') }}
        </a>
        <button class="" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            TOGGLE<span class="navbar-toggler-icon"></span>
        </button>

        <div class="" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="">

            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="">
                <!-- Authentication Links -->
                @guest
                    <li class="">
                        <a class="" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>

                @else

                    <li class="">
                        <a id="navbarDropdown" class="" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="" aria-labelledby="navbarDropdown">

                            <a class="" href="{{ route('home') }}">Home</a>

                            @if (Route::has('register'))

                                <a class="" href="{{ route('register') }}">{{ __('Register') }}</a>

                            @endif

                            <a class="" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>

</nav>
