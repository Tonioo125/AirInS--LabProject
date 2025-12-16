@extends('layouts.main')

@section('content')
<div class="container py-5" style="max-width: 700px;">
    <h2 class="fw-semibold mb-4">My Profile</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label fw-semibold">Name</label>
            <input type="text" name="name" id="name" 
                   class="form-control @error('name') is-invalid @enderror" 
                   value="{{ old('name', $user->name) }}" required>
            @error('name')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label fw-semibold">Email</label>
            <input type="email" name="email" id="email" 
                   class="form-control @error('email') is-invalid @enderror" 
                   value="{{ old('email', $user->email) }}" required>
            @error('email')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label for="gender" class="form-label fw-semibold">Gender</label>
            <select name="gender" id="gender" class="form-select">
                <option value="" disabled {{ !$user->gender ? 'selected' : '' }}>Select gender</option>
                <option value="Male" {{ $user->gender == 'Male' ? 'selected' : '' }}>Male</option>
                <option value="Female" {{ $user->gender == 'Female' ? 'selected' : '' }}>Female</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label fw-semibold">Phone</label>
            <input type="text" name="phone" id="phone" 
                   class="form-control @error('phone') is-invalid @enderror" 
                   value="{{ old('phone', $user->phone) }}">
            @error('phone')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-danger reds-bg px-4">Update Profile</button>
        </div>
    </form>
</div>
@endsection
