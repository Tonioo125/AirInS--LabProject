@extends('layouts.main')
@section('title', 'Register')
@section('content')
<div class="d-flex flex-column justify-content-center align-items-center" style="height: 100vh;">
    <form class="shadow w-25 rounded p-3 bg-white" style="height: fit-content;" action="/register" method="POST">
        <div class="mb-3 mt-4 d-flex justify-content-center">
            <img src="assets/logo.png" class="h-25" style="width: 120px; height: auto;" alt="">
        </div>
        @csrf
        <h5 class="fw-bold text-center">Create your account</h5>
        @if($errors->any())
            <div class="py-2 mb-3 text-center text-danger" role="alert">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="mb-3">
            <label for="name" class="form-label fw-bold">Name</label>
            <input class="form-control form-control-sm" type="text" name="name" value="{{ old('name') }}" style="font-size: 0.875rem;">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label fw-bold">Email</label>
            <input class="form-control form-control-sm" type="email" name="email" value="{{ old('email') }}" style="font-size: 0.875rem;">
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label fw-bold">Phone</label>
            <input class="form-control form-control-sm" type="text" name="phone" value="{{ old('phone') }}" style="font-size: 0.875rem;">
        </div>

        <div class="mb-3">
            <label for="gender" class="form-label fw-bold">Gender</label>
            <select class="form-select form-select-sm" name="gender" style="font-size: 0.875rem;">
                <option value="" {{ old('gender')=='' ? 'selected' : '' }}>Select gender</option>
                <option value="male" {{ old('gender')=='male' ? 'selected' : '' }}>Male</option>
                <option value="female" {{ old('gender')=='female' ? 'selected' : '' }}>Female</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label fw-bold">Password</label>
            <input class="form-control form-control-sm" type="password" name="password" style="font-size: 0.875rem;">
        </div>
        <div class="mb-3">
            <label for="password_confirmation" class="form-label fw-bold">Confirm Password</label>
            <input class="form-control form-control-sm" type="password" name="password_confirmation" style="font-size: 0.875rem;">
        </div>

        <div class="d-grid mb-2">
            <button class="btn text-center btn-danger" style="background-color: rgb(252, 62, 141);" type="submit">Register</button>
        </div>

        <div>
            <p class="text-center">Already have an account?
                <a class="text-decoration-none" style="color: rgb(252, 62, 141)" href="/login">Login</a>
            </p>
        </div>

        
    </form>
</div>
@endsection