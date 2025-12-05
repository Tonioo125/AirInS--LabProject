<div class="property-card">
    <div class="property-image-wrapper">
        <a href="{{ route('bookings.detail', $property->id) }}">
            <img src="{{ asset('storage/'.$property->photos) }}" alt="Property Image" class="property-image">
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
    </div>

    <div class="property-info">
        <div class="property-title fw-semibold">{{ $property->title }}</div>
        <div class="property-location text-secondary small">{{ $property->location }}</div>
        <p class="property-price mb-0">
            Rp{{ number_format($property->price, 0, ',', '.') }}
            <span class="text-secondary fw-normal">/ night</span>
        </p>
    </div>
</div>

@push('styles')
<style>
    .property-card {
        background-color: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        overflow: hidden;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        position: relative;
        width: 100%;
        max-width: 280px;
        margin: 0;
    }

    .property-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0,0,0,0.12);
    }

    .property-image-wrapper {
        position: relative;
    }

    .property-image {
        width: 100%;
        max-height: 200px;
        object-fit: cover;
        display: block;
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

    .property-title {
        font-size: 15px;
        color: #1a1a1a;
        margin-bottom: 2px;
    }

    .property-location {
        font-size: 13px;
        color: #777;
        margin-bottom: 6px;
    }

    .property-price {
        font-size: 14px;
        color: #d6334c;
        font-weight: 600;
    }

</style>
@endpush
