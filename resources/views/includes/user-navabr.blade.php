<nav class="navbar navbar-expand-lg navbar-light bg-blue">
    <div class="container">
        <a class="navbar-brand text-white" href="{{ url('/') }}">{{ env('APP_NAME') }}</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                @guest
                    <li class="nav-item {{ request()->is('/') ? 'active' : '' }}">
                        <a class="nav-link text-white" href="{{ url('/') }}">Login</a>
                    </li>
                    <li class="nav-item {{ request()->is('registration') ? 'active' : '' }}">
                        <a class="nav-link text-white" href="{{ url('/registration') }}">Register</a>
                    </li>
                    <li class="nav-item {{ request()->is('contact') ? 'active' : '' }}">
                        <a class="nav-link text-white" href="{{ url('contact') }}">Contact</a>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
