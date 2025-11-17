<nav style="background:#f8f9fa;padding:1em;display:flex;justify-content:space-between;align-items:center;">
    <div>
        <a href="/home">Home</a>
    </div>
    <div>
        @if(Auth::check())
            <span>{{ Auth::user()->name }}</span>
            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" style="background:none;border:none;color:#007bff;cursor:pointer;">Logout</button>
            </form>
        @else
            <a href="{{ route('login') }}" style="margin-right:10px;">Login</a>
            <a href="{{ route('register') }}">Sign Up</a>
        @endif
    </div>
</nav>
