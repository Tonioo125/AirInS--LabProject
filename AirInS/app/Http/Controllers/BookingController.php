<?php

namespace App\Http\Controllers;

use App\Models\BookingDetail;
use App\Models\BookingHeader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BookingController extends Controller
{
    // menampilkan semua booking milik user
    public function index()
    {
        $user = Auth::user();
        $bookings = BookingHeader::with(['bookingDetails.property'])
            ->where('user_id', $user->id)
            ->orderBy('check_in_date', 'desc')
            ->get();
        return view('bookings.index', compact('bookings'));
    }

    // cancel booking
    public function cancel($id)
    {
        $booking = BookingHeader::findOrFail($id);
        if($booking->user_id !== Auth::user()->id){
            abort(403);
        }
        $booking->delete();

        return redirect()->route('bookings')->with('success', 'Booking canceled successfully.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Log::info('BookingController@store called', [
            'user_id' => Auth::id(),
            'payload' => $request->all(),
        ]);

        $request->validate([
            'property_id' => 'required|exists:properties,id',
            'check_in' => 'required|date|after:today',
            'check_out' => 'required|date|after:check_in',
            'guests' => 'required|integer|min:1',
        ]);

        if (!Auth::check()) {
            Log::warning('Store attempted without auth');
            return redirect()->route('login')->with('error', 'Anda harus login untuk memesan.');
        }

        try {
            DB::beginTransaction();

            $property = \App\Models\Property::findOrFail($request->property_id);

            if ($property->user_id === Auth::id()) {
                Log::warning('Host attempted to book own property', ['property_id' => $property->id]);
                return back()->withInput()->with('error', 'Host tidak dapat memesan properti sendiri.');
            }

            $overlap = BookingDetail::where('property_id', $property->id)
                ->whereHas('bookingHeader', function ($q) use ($request) {
                    $q->where(function ($w) use ($request) {
                        $w->whereBetween('check_in_date', [$request->check_in, $request->check_out])
                          ->orWhereBetween('check_out_date', [$request->check_in, $request->check_out])
                          ->orWhere(function ($o) use ($request) {
                              $o->where('check_in_date', '<=', $request->check_in)
                                ->where('check_out_date', '>=', $request->check_out);
                          });
                    });
                })->exists();

            Log::info('Overlap check result', ['overlap' => $overlap]);

            if ($overlap) {
                DB::rollBack();
                return back()->withInput()->with('error', 'Tanggal yang dipilih sudah dibooking.')
                    ->with('debug_overlap', true);
            }

            $nights = Carbon::parse($request->check_in)->diffInDays(Carbon::parse($request->check_out));
            if ($nights < 1) {
                DB::rollBack();
                return back()->withInput()->with('error', 'Durasi inap minimal 1 malam.')
                    ->with('debug_nights', $nights);
            }

            $totalPrice = $property->price * $nights;

            $bookingHeader = BookingHeader::create([
                'user_id' => Auth::id(),
                'booking_date' => now(),
                'check_in_date' => $request->check_in,
                'check_out_date' => $request->check_out,
                'total_price' => $totalPrice,
                'status' => 'pending',
            ]);

            $bookingDetail = BookingDetail::create([
                'booking_id' => $bookingHeader->id,
                'property_id' => $property->id,
                'guest_count' => $request->guests,
                'price_per_night' => $property->price,
            ]);

            DB::commit();

            Log::info('Booking stored successfully', [
                'booking_id' => $bookingHeader->id,
                'booking_detail_id' => $bookingDetail->id,
            ]);

            return redirect()
                ->route('bookings')
                ->with('success', 'Booking berhasil dibuat!')
                ->with('debug_booking_id', $bookingHeader->id)
                ->with('debug_booking_detail_id', $bookingDetail->id);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Booking store failed', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return back()
                ->withInput()
                ->with('error', 'Gagal menyimpan booking.')
                ->with('debug_exception', get_class($e))
                ->with('debug_message', $e->getMessage());
        }
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
