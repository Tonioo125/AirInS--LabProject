<!-- <link rel="stylesheet" href="{{ asset('/css/card.css') }}"> -->
<div class="property-card">

    {{-- Jika user login -> ke detail, jika guest -> ke login --}}
    <a href="{{ route('bookings.detail', $property->id) }}">
        <img src="{{ asset('storage/'.$property->photos) }}" alt="Property Image">
    </a>

    <div class="property-info">
        <div class="property-title">{{ $property->title }}</div>

        <div class="property-location">{{ $property->location }}</div>

        <div class="property-price">
            Rp{{ number_format($property->price, 0, ',', '.') }} / night
        </div>
    </div>
</div>