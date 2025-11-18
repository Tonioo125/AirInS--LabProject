<link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/custom.css') }}">

<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm">
    <div class="container-fluid mx-5">
        <a class="navbar-brand fw-semibold logo" href="{{ auth()->check() ? route('home') : route('welcome') }}">AirInS</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar"
            aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="mt-2 mt-lg-0" style="max-width: 75vw; width: 100%;">
            <form class="d-flex" action="{{ route('search') }}" method="GET">
                <div class="input-group">
                    <input class="form-control form-control-sm"
                        type="text"
                        name="keyword"
                        placeholder="Search properties..."
                        value="{{ request('keyword') }}">
                    <button class="btn btn-outline-primary btn-sm" type="submit">Search</button>
                </div>
            </form>
        </div>

            <ul class="navbar-nav ms-auto align-items-lg-center">
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="/about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Log in</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-primary btn-sm ms-lg-2 mt-2 mt-lg-0" href="{{ route('register') }}">Sign up</a>
                    </li>
                @endguest

                @auth
                    <li class="nav-item">
                        <a class="nav-link" href="/about">About Us</a>
                    </li>

                    {{-- User Dropdown --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userMenu"
                           role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="me-1"> Hello {{ auth()->user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="userMenu">
                            <li><a class="dropdown-item" href="/profile">Profile</a></li>
                            <li><a class="dropdown-item" href="/bookings">My Bookings</a></li>
                            <li><a class="dropdown-item" href="/favorites">Favorites</a></li>
                            <li><a class="dropdown-item" href="/properties/add">Add Property</a></li>
                            <li><a class="dropdown-item" href="/my-properties">My Properties</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="px-3 py-1">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm w-100">Sign out</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>

