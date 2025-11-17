<form class="register-form" action="/register" method="POST">
    @csrf
    <input type="text" name="name" placeholder="Name" value="{{ old('name') }}">
    <input type="email" name="email" placeholder="Email" value="{{ old('email') }}">
    <input type="text" name="phone" placeholder="Phone" value="{{ old('phone') }}">

    <select name="gender">
        <option value="">SELECT Gender</option>
        <option value="male">Male</option>
        <option value="female">Female</option>
    </select>

    <input type="password" name="password" placeholder="Password">
    <input type="password" name="password_confirmation" placeholder="Confirm Password">

    <button type="Submit">Sign Up</button>

    <a href="/login">Already have an account?</a>

    @if($errors->any())
        <ul>
        @foreach($errors->all() as $error)
            <li style="color:red;">{{ $error }}</li>
        @endforeach
        </ul>
    @endif

</form>