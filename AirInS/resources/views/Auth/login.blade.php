<form action="/login" method="POST">
    @csrf
    <input type="email" name="email" placeholder="Email" value="{{ old('email') }}">
    <input type="password" name="password" placeholder="Password">

    <label>
        <input type="checkbox" name="remember"> Remember Me
    </label>

    <button type="submit">Sign In</button>
    <a href="/register">Don't have an account?</a>

    @error('email')
        <p  style="color:red">{{$message}}</p>
    @enderror
</form>