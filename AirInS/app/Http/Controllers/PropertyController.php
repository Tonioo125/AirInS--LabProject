<?php

namespace App\Http\Controllers;

use App\Models\BookingHeader;
use App\Models\Property;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use SebastianBergmann\Environment\Console;
use Illuminate\Support\Str;

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
        $categories = \App\Models\PropertyCategory::all();
        return view('properties.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:property_categories,id',
            'description' => 'required|string',
            'photos' => 'required|image|max:2048', // 2MB
            'is_available' => 'nullable|in:0,1',
        ]);

        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to create a property.');
        }

        $photoPath = null;
        if ($request->hasFile('photos')) {
            $photoPath = $request->file('photos')->store('properties', 'public');
        }

        $property = Property::create([
            'id' => Str::upper(Str::random(5)),
            'user_id' => Auth::id(),
            'category_id' => $request->input('category_id'),
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'photos' => $photoPath,
            'location' => $request->input('location'),
            'price' => $request->input('price'),
            'is_available' => '1',
        ]);

        return redirect()->route('property.index')->with('success', 'Property created successfully.');
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

        // concat reviews with user info
        foreach ($reviews as $review) {
            $review->user = $review->bookingHeader->airusers;
        }

        return view('bookings.detail', compact('property', 'userHasCompleted', 'reviews'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $property = Property::findOrFail($id);

        // Only owner or admin can edit
        if (Auth::user()->role !== 'admin' && $property->user_id !== Auth::id()) {
            abort(403);
        }

        $categories = \App\Models\PropertyCategory::all();
        return view('properties.edit', compact('property', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $property = Property::findOrFail($id);

        if (Auth::user()->role !== 'admin' && $property->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:property_categories,id',
            'description' => 'required|string',
            'photos' => 'required|image|max:2048',
            'is_available' => 'nullable|in:0,1',
        ]);

        // Handle optional photo replace
        if ($request->hasFile('photos')) {
            $newPath = $request->file('photos')->store('properties', 'public');
            $property->photos = $newPath;
        }

        $property->title = $request->input('title');
        $property->location = $request->input('location');
        $property->price = $request->input('price');
        $property->category_id = $request->input('category_id');
        $property->description = $request->input('description');
        $property->is_available = $request->input('is_available', $property->is_available);
        $property->save();

        return redirect()->route('property.index')->with('success', 'Property updated successfully.');
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');

        $properties = Property::where('title', 'like', "%{$keyword}%")
            ->orWhere('location', 'like', "%{$keyword}%")
            ->paginate(8)
            ->withQueryString();
        return view('properties.search', compact('properties', 'keyword'));
    }

    public function myProperties(){
        $user = Auth::user();

        // Admin melihat semua property
        if ($user->role === 'admin') {
            $properties = Property::with('propertyCategories')
                ->orderBy('created_at', 'desc')
                ->paginate(6);
        } 
        // Member hanya melihat property miliknya
        else {
            $properties = Property::with('propertyCategories')
                ->where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->paginate(6);
        }
        return view('properties.user_properties', compact('properties'));
    }
    public function destroy($id){
        $property = Property::findOrFail($id);

        // Cek kepemilikan kecuali admin
        if (Auth::user()->role !== 'admin' && $property->user_id != Auth::id()) {
            abort(403);
        }

        // Hapus foto dari storage (public disk)
        if (!empty($property->photos)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($property->photos);
        }

        $property->delete();

        return redirect()->route('property.index')->with('success', 'Property deleted successfully.');
    }
}