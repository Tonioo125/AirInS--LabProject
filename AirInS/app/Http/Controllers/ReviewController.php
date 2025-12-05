<?php

namespace App\Http\Controllers;

use App\Models\BookingHeader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Review;
use Illuminate\Support\Str;

class ReviewController extends Controller
{
    //
    public function create($bookingId)
    {
            $booking = BookingHeader::with(['bookingDetails.property', 'reviews'])
            ->where('id', $bookingId)
            ->firstOrFail();

        // Ownership check
        if ($booking->user_id !== Auth::id()) {
            return redirect()->route('bookings.index')->with('error', 'You cannot review this booking.');
        }

        // Must be completed (use strict > comparison like the listings page)
        if (now()->lessThanOrEqualTo($booking->check_out_date)) {
            return redirect()->route('bookings.index')->with('error', 'You can only review after your stay is completed.');
        }

        // Only one review per booking
        if ($booking->reviews) {
            return redirect()->route('bookings.index')->with('error', 'You have already submitted a review.');
        }

        return view('review.create', compact('booking'));
    }
    public function store(Request $request, $bookingId)
    {
        $booking = BookingHeader::with('reviews')->where('id', $bookingId)->firstOrFail();

        // Ownership
        if ($booking->user_id !== Auth::id()) {
            return redirect()->route('bookings.index')->with('error', 'You cannot review this booking.');
        }

        // Must be completed
        if (now()->lessThanOrEqualTo($booking->check_out_date)) {
            return redirect()->route('bookings.index')->with('error', 'You can only review after your stay is completed.');
        }

        // Only one review per booking
        if ($booking->reviews) {
            return redirect()->route('bookings.index')->with('error', 'You have already submitted a review.');
        }

        // Validate
        $validated = $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:255',
        ]);

        Review::create([
            'id'         => Str::upper(Str::random(5)),
            'booking_id' => $booking->id,
            'rating'     => $validated['rating'],
            'comment'    => $validated['comment'],
        ]);

        return redirect()->route('bookings.index')->with('success', 'Review submitted successfully!');
    }

}
