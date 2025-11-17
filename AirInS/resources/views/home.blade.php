<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    @include('components.navbar')
    <!-- return success login and dont if not logged in -->
     @if(!Auth::check())
        <h2 style="color:red;">You are not logged in. Please <a href="{{ route('login.show') }}">Login</a>.</h2>
    @else
        <h1>Welcome, {{ Auth::user()->name }}!</h1>
        <p>You have successfully logged in.</p>
    @endif
</body>
</html>