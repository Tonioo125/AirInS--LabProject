@extends('layouts.main')
@section('title', 'Login')
@section('content')
<div class="d-flex flex-column justify-content-center align-items-center" style="height: 80vh;">
    <form class="shadow w-25 rounded p-4 bg-white" style="height: fit-content; min-width: 400px;" action="/login" method="POST">
        <div class="mb-4 mt-4 d-flex justify-content-center">
            <img src="assets/logo.png" class="h-25" style="width: 120px; height: auto;" alt="">
        </div>
        @csrf
        <h5 class="fw-bold mb-3 text-center">Login to your account</h5>
        @if ($errors->has('login_error'))
            <p class="text-danger text-center small mb-3">{{ $errors->first('login_error') }}</p>
        @endif
        <div class="mb-3">
            <label for="email" class="form-label-sm fw-bold ">Email</label>
            <input class="form-control form-control" type="email" name="email" value="{{ old('email') }}" style="font-size: 0.875rem;">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label-sm fw-bold">Password</label>
            <input class="form-control form-control" type="password" name="password" style="font-size: 0.875rem;">
        </div>

        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="remember">
            <label class="form-check-label" for="remember">Remember Me</label>
        </div>

        <div class="d-grid mb-3">
            <button class="btn text-center btn-danger" style="background-color: rgb(252, 62, 141);" type="submit">Login</button>
        </div>

        <div>
            <p class="text-center">Don't have an account? 
                <a class="text-decoration-none" style="color: rgb(252, 62, 141)"
                href="/register">Register</a></p>
        </div>
    </form>
</div>
@endsection

@push('styles')
<style>
    .form-control:focus,
    .form-select:focus {
        outline: 2px solid #dc3545; /* red outline */
        border-color: #dc3545;
        box-shadow: none;
    }
    /* Show red outline when invalid via server-side error */
    .is-invalid {
        outline: 2px solid #dc3545;
        border-color: #dc3545;
    }
</style>
@endpush