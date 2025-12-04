@extends('layouts.main')

@section('content')

<div class="container" style="max-width: 700px; margin: 40px auto;">

    <h3 class="fw-bold mb-4">Write a Review</h3>

    <div style="background:#fff; padding:25px; border-radius:12px; box-shadow:0 3px 10px rgba(0,0,0,0.1);">

        <h4 class="fw-medium">{{ $booking->bookingDetails->first()->property->title }}</h4>
        <p class="text-secondary">Check-out: {{ $booking->check_out_date }}</p>

        <form action="{{ route('review.store', $booking->id) }}" method="POST">
            @csrf

            {{-- Rating --}}
            <label>Rating</label>
            <select name="rating" class="form-control" required>
                <option value="">Select rating</option>
                <option value="5">★★★★★</option>
                <option value="4">★★★★☆</option>
                <option value="3">★★★☆☆</option>
                <option value="2">★★☆☆☆</option>
                <option value="1">★☆☆☆☆</option>
            </select>
            @error('rating')
                <p style="color:red">{{ $message }}</p>
            @enderror

            {{-- Comment --}}
            <label class="mt-3">Comment</label>
            <textarea name="comment" class="form-control" rows="4" placeholder="What did you like or dislike?" required></textarea>
            @error('comment')
                <p style="color:red">{{ $message }}</p>
            @enderror

            <button type="submit" class="btn btn-danger reds-bg mt-4 w-100" style="padding:12px">
                Submit Review
            </button>

        </form>
    </div>

</div>

@endsection