<div class="property-card">

    {{-- Jika user login -> ke detail, jika guest -> ke login --}}
    <a href="{{ auth()->check() ? '/property/'.$property->id : '/login' }}">
        <img src="{{ asset('storage/'.$property->photos) }}" alt="Property Image">
    </a>

    <div class="property-title">{{ $property->title }}</div>

    <div class="property-location">{{ $property->location }}</div>

    <div class="property-price">
        Rp{{ number_format($property->price, 0, ',', '.') }} / night
    </div>

</div>
