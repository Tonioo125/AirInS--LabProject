<?php

namespace App\Http\Controllers;

use App\Models\BookingDetail;
use App\Models\BookingHeader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Psy\Readline\Hoa\Console;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    // menampilkan semua booking milik user
    public function index()
    {
        $user = Auth::user();
        $bookings = BookingHeader::with(['bookingDetails.property', 'reviews'])
            ->where('user_id', $user->id)
            ->orderBy('check_in_date', 'desc')
            ->get();

        $isCompleted = function ($booking) {
            return now()->greaterThan($booking->check_out_date);
        };
        
        return view('bookings.index', compact('bookings', 'isCompleted'));
    }

    // cancel booking
    public function cancel($id)
    {
        $booking = BookingHeader::findOrFail($id);
        if($booking->user_id !== Auth::user()->id){
            abort(403);
        }
        $booking->delete();

        return redirect()->route('bookings.index')->with('success', 'Booking canceled successfully.');
    }

    public function create()
    {
        //
    }

    public function store(Request $request, $id)
    {
        // dump($request->all());

        $bookedRanges = BookingHeader::whereHas('bookingDetails', function($q) use ($id) {
                $q->where('property_id', $id);
            })
            ->get(['check_in_date', 'check_out_date']);
        
        if ($bookedRanges) {
            foreach ($bookedRanges as $range) {
                $existingStart = new \DateTime($range->check_in_date);
                $existingEnd = new \DateTime($range->check_out_date);
                $requestedStart = new \DateTime($request->check_in);
                $requestedEnd = new \DateTime($request->check_out);

                // Check for overlap
                if ($requestedStart <= $existingEnd && $requestedEnd >= $existingStart) {
                    return redirect()->back()
                    ->with('error', 'The property is unavailable for the selected dates. Please select another dates range')->withInput();
                }
            }
        }
        
        $request->validate([
            'property_id' => 'required|exists:properties,id',
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
            'guests' => 'required|integer|min:1',
        ]);

        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Anda harus login untuk memesan.');
        }

        $totalNights = (new \DateTime($request->check_out))->diff(new \DateTime($request->check_in))->days;
        $totalNights += 1; // termasuk hari check-in
        $property = \App\Models\Property::findOrFail($request->property_id);
        $totalPrice = $property->price * $totalNights;
        

        // Debug
        // dump('Total Nights: ' . $totalNights);
        // dump('Price per Night: ' . $property->price);
        // dump('Total Price: ' . $totalPrice);

        // Buat BookingHeader
        $bookingHeader = BookingHeader::create([
            'id' => Str::upper(Str::random(5)),
            'user_id' => Auth::id(),
            'booking_date' => now(),
            'check_in_date' => $request->check_in,
            'check_out_date' => $request->check_out,
            'total_price' => $totalPrice, // Harga akan dihitung nanti
        ]);

        // Buat BookingDetail
        BookingDetail::create([
            'booking_id' => $bookingHeader->id,
            'property_id' => $request->property_id,
            'guest_count' => $request->guests,
            'price_per_night' => $property->price, // Harga akan diatur nanti
        ]);

        //return errror kalo ada masalah


        return redirect()->route('bookings.index')->with('success', 'Booking berhasil dibuat!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
