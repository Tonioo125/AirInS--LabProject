<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $property->title }} - Detail</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .property-detail { max-width: 900px; margin: 0 auto; }
        .booking-form { border: 1px solid #ddd; padding: 20px; margin-top: 30px; border-radius: 8px; }
        .reviews { margin-top: 40px; }
        .review { border-left: 3px solid #007bff; padding: 15px; margin: 10px 0; background: #f9f9f9; }
        button { background: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background: #0056b3; }
    </style>
</head>
<body>
    <div class="property-detail">
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
            <form action="{{ auth()->check() ? route('bookings.store') : route('login') }}" method="POST">
                @csrf
                <input type="hidden" name="property_id" value="{{ $property->id }}">
                
                <div style="margin: 10px 0;">
                    <label for="check_in">Check-in:</label>
                    <input type="date" id="check_in" name="check_in" required>
                </div>
                
                <div style="margin: 10px 0;">
                    <label for="check_out">Check-out:</label>
                    <input type="date" id="check_out" name="check_out" required>
                </div>
                
                <div style="margin: 10px 0;">
                    <label for="guests">Jumlah Tamu:</label>
                    <input type="number" id="guests" name="guests" min="1" required>
                </div>
                <button type="submit">{{ auth()->check() ? 'Pesan Sekarang' : 'Login untuk Pesan' }}</button>
            </form>
        </div>

        {{-- Reviews Section --}}
        <div class="reviews">
            <h3>Ulasan Pengguna</h3>

            {{-- Display Reviews --}}
            @if($property->reviews && $property->reviews->count() > 0)
                @foreach($property->reviews as $review)
                    <div class="review">
                        <strong>{{ $review->user->name }}</strong> - ⭐ {{ $review->rating }}/5
                        <p>{{ $review->comment }}</p>
                        <small>{{ $review->created_at->format('d M Y') }}</small>
                    </div>
                @endforeach
            @else
                <p style="color: #666;">Belum ada ulasan untuk properti ini.</p>
            @endif
        </div>
        
        <br>
        <a href="{{ route('home') }}">← Kembali</a>
    </div>
</body>
</html>