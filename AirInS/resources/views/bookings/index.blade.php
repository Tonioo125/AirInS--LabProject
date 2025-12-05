@extends('layouts.main')

@section('content')
<div class="my-bookings-container">
    <h3 class="mb-4 fw-bold">My Bookings</h3>

    @if ($bookings->isEmpty())
        <p class="no-booking">You have no bookings yet.</p>
    @else
        @foreach ($bookings as $booking)
            @php $detail = $booking->bookingDetails; @endphp
            @if ($detail && is_object($detail) && $detail->property)
                @php
                    $property = $detail->property;
                    $isCompleted = now()->gt($booking->check_out_date);
                @endphp

                <div class="booking-card d-flex flex-row mb-4">
                    <a href="/property/detail/{{ $property->id }}">
                        <img src="{{ asset('storage/'.$property->photos) }}" alt="{{ $property->title }}">
                    </a>

                    <div class="booking-info w-100 border shadow-sm">
                        <div class="py-4 px-3">
                            <h4 class="mb-2">{{ $property->title }}</h4>
                            <p class="location text-secondary mb-1">{{ $property->location }}</p>
                            <p class="dates text-secondary mb-1">
                                Check-in: {{ $booking->check_in_date }} <br>
                                Check-out: {{ $booking->check_out_date }}
                            </p>
                            <p class="price reds-color fw-semibold mb-1">Rp {{ number_format($booking->total_price ?? 0, 0, ',', '.') }}</p>
    
                            @if ($isCompleted)
                                <div class="d-flex flex-row align-items-center justify-content-between">
                                    <p class="status completed text-secondary mb-0">Booking completed</p>
                                    @if (!$booking->reviews)
                                        <a href="{{ route('review.create', $booking->id) }}"
                                           class="btn btn-danger rounded reds-bg btn-review">
                                            Leave a Review
                                        </a>
                                    @else
                                        <p class="status fw-bold reviewed mb-0">Review submitted</p>
                                    @endif
                                </div>
                            @else
                                <form action="{{ route('bookings.cancel', $booking->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this booking?')">
                                    @csrf
                                    <button type="submit" class="cancel btn btn-outline-danger">Cancel Booking</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    @endif
</div>
@endsection

@push('styles')
<style>
.my-bookings-container {
    padding: 40px 80px
}

img {
    width: 320px;
    height: 240px;
    object-fit: cover;
    border-radius: 12px 0 0 12px;
}
.booking-info{
    border-radius: 0 12px 12px 0 ;
}
.price{
    font-size: 18px;
}

.cancel{
    background-color: rgba(255, 218, 218, 1);
    border: none !important;
}
</style>
@endpush
