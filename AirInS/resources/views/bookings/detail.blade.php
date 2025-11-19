@extends('layouts.main')

@section('content')
<div class="property-detail">
    {{-- Tampilkan error validasi --}}
    @if ($errors->any())
    <div style="color: #b94a48; background: #f2dede; border: 1px solid #eed3d7; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
        <ul style="margin: 0; padding-left: 20px;">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <h1>{{ $property->title }}</h1>

    <img src="{{ asset('storage/'.$property->photos) }}" alt="{{ $property->title }}" style="width: 100%; max-width: 600px; border-radius: 8px;">

    <div class="property-info">
        <p><strong>Lokasi:</strong> {{ $property->location }}</p>
        <p><strong>Kategori:</strong> {{ optional($property->propertyCategories)->name ?? 'N/A' }}</p>
        <p><strong>Harga:</strong> Rp{{ number_format($property->price, 0, ',', '.') }} / malam</p>
        <p><strong>Deskripsi:</strong> {{ $property->description ?? 'Tidak ada deskripsi' }}</p>
        <p><strong>Host:</strong> {{ optional($property->airusers)->name ?? 'N/A' }}</p>
    </div>

    {{-- Booking Form --}}
    <div class="booking-form">
        <h3>Form Pemesanan</h3>

        <form action="{{ route('bookings.store') }}" method="POST">
            @csrf
            <input type="hidden" name="property_id" value="{{ $property->id }}">

            <div style="margin: 10px 0;">
                <label for="check_in">Check-in:</label>
                <input type="date" id="check_in" name="check_in" value="{{ old('check_in') }}" required>
            </div>

            <div style="margin: 10px 0;">
                <label for="check_out">Check-out:</label>
                <input type="date" id="check_out" name="check_out" value="{{ old('check_out') }}" required>
            </div>

            <div style="margin: 10px 0;">
                <label for="guests">Jumlah Tamu:</label>
                <input type="number" id="guests" name="guests" min="1" value="{{ old('guests') }}" required>
            </div>
            @if(auth()->check())
            <button type="submit">Pesan Sekarang</button>
            @else
            <a href="{{ route('login') }}">
                <button type="button">Login untuk Pesan</button>
            </a>
            @endif
        </form>
    </div>

    {{-- Reviews Section --}}
    <div class="reviews">
        <h3>Ulasan Pengguna</h3>
        @if(isset($reviews) && $reviews->count() > 0)
        @foreach($reviews as $review)
        <div class="review">
            <strong>{{ optional($review->user)->name ?? 'Anonim' }}</strong> - ⭐ {{ $review->rating }}/5
            <p>{{ $review->comment }}</p>
            <small>{{ \Illuminate\Support\Carbon::parse($review->created_at)->format('d M Y') }}</small>
        </div>
        @endforeach
        @else
        <p style="color: #666;">Belum ada ulasan untuk properti ini.</p>
        @endif
    </div>

    <br>
    <a href="{{ route('home') }}">← Kembali</a>
</div>
@endsection