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
        $booking = BookingHeader::with('bookingDetails.property')
            ->where('id', $bookingId)
            ->firstOrFail();

        // Cek kepemilikan booking
        if ($booking->user_id != Auth::id()) {
            return redirect('/bookings')->with('error', 'You cannot review this booking.');
        }

        // Pastikan checkout sudah lewat
        if (now()->lt($booking->check_out_date)) {
            return redirect('/bookings')->with('error', 'You can only review after your stay is completed.');
        }

        // Pastikan belum pernah review
        if ($booking->review) {
            return redirect('/bookings')->with('error', 'You have already submitted a review.');
        }
        return view('review.create', compact('booking'));
    }
    public function store(Request $request, $bookingId)
    {
        $booking = BookingHeader::where('id', $bookingId)->firstOrFail();

        // Validasi
        $validated = $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:255',
        ]);

        Review::create([
            'id'  => Str::upper(Str::random(5)),
            'booking_id' => $booking->id,
            'rating'    => $validated['rating'],
            'comment'   => $validated['comment'],
        ]);

        return redirect('/bookings')->with('success', 'Review submitted successfully!');
    }

}
