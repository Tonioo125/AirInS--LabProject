@extends('layouts.main')

@section('content')
<div class="my-bookings-container">
    <h2>My Bookings</h2>

    @if ($bookings->isEmpty())
        <p class="no-booking">You have no bookings yet.</p>
    @else
        @foreach ($bookings as $booking)
            @php $detail = $booking->bookingDetails->first(); @endphp
            @if ($detail && is_object($detail) && $detail->property)
                @php
                    $property = $detail->property;
                    $isCompleted = now()->gt($booking->check_out_date);
                @endphp

                <div class="booking-card">
                    <a href="/property/detail/{{ $property->id }}">
                        <img src="{{ asset('storage/'.$property->photos) }}" alt="{{ $property->title }}">
                    </a>

                    <div class="booking-info">
                        <h3>{{ $property->title }}</h3>
                        <p class="location">{{ $property->location }}</p>
                        <p class="dates">
                            Check-in: {{ $booking->check_in_date }} <br>
                            Check-out: {{ $booking->check_out_date }}
                        </p>
                        <p class="price">Rp {{ number_format($booking->total_price ?? 0, 0, ',', '.') }}</p>

                        @if ($isCompleted)
                            <p class="status completed">Booking completed</p>
                            @if (!$booking->reviews)
                                <a href="{{ route('review.create', $booking->id) }}"
                                   class="btn btn-review">
                                    Leave a Review
                                </a>
                            @else
                                <p class="status reviewed">Review submitted</p>
                            @endif
                        @else
                            <form action="{{ route('bookings.cancel', $booking->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this booking?')">
                                @csrf
                                <button type="submit" class="btn btn-cancel">Cancel Booking</button>
                            </form>
                        @endif
                    </div>
                </div>
            @endif
        @endforeach
    @endif
</div>
@endsection
