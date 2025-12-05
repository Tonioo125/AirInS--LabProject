@extends('layouts.main')

@section('content')
<div class="container py-4">
    <h3 class="titles mb-4 fw-semibold">My Favorite Properties</h3>

    @if(session('success'))
    <div class="alert alert-success mb-4">{{ session('success') }}</div>
    @endif

    @if($favorites->isEmpty())
    <p class="favorite text-muted px-2">You haven’t favorited any properties yet.</p>
    @else
    <div class="row g-4 py-3 px-2">
        @foreach($favorites as $fav)
        @php
        $property = $fav->property;
        // Tambahkan flag is_favorited agar card bisa tampil dengan ikon heart penuh
        $property->is_favorited = true;
        @endphp

        <div class="col-12 col-sm-6 col-lg-4">
            <div class="card h-100 shadow-sm border-0">
                <a href="{{ route('bookings.detail', $property->id) }}" class="text-decoration-none">
                    <img src="{{ asset('storage/' . $property->photos) }}" class="card-img-top" alt="{{ $property->title }}" style="height:200px; object-fit:cover;">
                </a>

                @auth
                <form action="{{ route('favorites.toggle', $property->id) }}" method="POST" class="favorite-btn">
                    @csrf
                    <button type="submit" class="btn border-0 p-0">
                        @if($property->is_favorited)
                        <img src="{{ asset('assets/full_heart.svg') }}" alt="Favorited" class="heart-icon">
                        @else
                        <img src="{{ asset('assets/heart.svg') }}" alt="Add to Favorite" class="heart-icon">
                        @endif
                    </button>
                </form>
                @endauth

                <div class="card-body d-flex flex-column">
                    <h5 class="card-title title mb-1 fw-bold">{{ $property->title }}</h5>
                    <p class="card-text location mb-2">{{ $property->location }}</p>
                    <p class="card-text price fw-semibold reds-color mb-0">Rp {{ number_format($property->price, 0, ',', '.') }}</p>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('bookings.detail', $property->id) }}" class="btn px-0 py-1 reds-color text-decoration-none">View Detail →</a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    .favorite{
        font-size: 16px;
    }
    .titles{
        padding: 40px 0 0 10px;
    }
    .card-img-top { border-top-left-radius: .5rem; border-top-right-radius: .5rem; }
    .category {
        font-size: 14px;
        color: #bdbdbdff;
    }
    .location{
        font-size: 15px;
        color: #999999ff;
    }
    .btn{
        font-size: 14px;
        border: none;
    }
    .container {
        padding: 40px 80px;
        margin: 0;
        min-width: 100%;
    }
    .favorite-btn {
        position: absolute;
        top: 12px;
        right: 12px;
        z-index: 10;
    }
    .favorite-btn button {
        padding: 20px;
        width: 32px;
        height: 40px;
        background-color: rgba(252, 252, 252, 0.71);
        border-radius: 80%;
        display: flex;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(2px);
        transition: background 0.2s ease;
    }
    .heart-icon {
        max-width: 20px;
        max-height: 20px;
        object-fit: contain;
        transition: transform 0.15s ease, opacity 0.15s ease;
    }
    .favorite-btn button:active .heart-icon {
        transform: scale(0.14);
    }
</style>
@endpush