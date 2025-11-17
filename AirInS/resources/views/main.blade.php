<nav class="navbar">
    <div class="left">
        <a href="{{ route('home') }}" class="logo">AirInS</a>
    </div>

    <div class="center">
        <form action="/search" method="GET">
            <input type="text" name="keyword" placeholder="Search properties...">
        </form>
    </div>

    <div class="right">

        @guest
            <a href="/about">About</a>
            <a href="/login">Log in</a>
            <a href="/register" class="btn-signup">Sign up</a>
        @endguest

        @auth
            <a href="/about">About Us</a>

            <div class="dropdown">
                <button class="dropdown-btn">
                    Hello, {{ auth()->user()->name }} ▼
                </button>
                <div class="dropdown-content">
                    <a href="/profile">Profile</a>
                    <a href="/bookings">My Bookings</a>
                    <a href="/favorites">Favorites</a>
                    <a href="/properties/add">Add Property</a>
                    <a href="/my-properties">My Properties</a>

                    <form action="/logout" method="POST">
                        @csrf
                        <button type="submit">Sign out</button>
                    </form>
                </div>
            </div>
        @endauth
    </div>
</nav>
