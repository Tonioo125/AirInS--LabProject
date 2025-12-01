<?php

namespace App\Http\Controllers;

use App\Models\BookingHeader;
use App\Models\Property;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use SebastianBergmann\Environment\Console;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $property = Property::with('airusers', 'bookingDetails.bookingHeader.airusers')->findOrFail($id);
        $userHasCompleted = false;

        if (Auth::check()) {
            $userHasCompleted = BookingHeader::where('user_id', Auth::id())
                ->whereHas('bookingDetails', function ($query) use ($id) {
                    $query->where('property_id', $id);
                })
                ->exists();
        }

        $bookingDetails = $property->bookingDetails;

        $reviews = \App\Models\Review::whereHas('bookingHeader.bookingDetails', function ($q) use ($id) {
            $q->where('property_id', $id);
        })->get();

        return view('bookings.detail', compact('property', 'userHasCompleted', 'reviews'));
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

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');

        $properties = Property::where('title', 'like', "%{$keyword}%")
            ->orWhere('location', 'like', "%{$keyword}%")
            ->paginate(8)
            ->withQueryString();
        return view('property.search', compact('properties', 'keyword'));
    }
}