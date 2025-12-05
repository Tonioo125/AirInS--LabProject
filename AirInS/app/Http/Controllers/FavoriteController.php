<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite;
use App\Models\Property;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    // Tampilkan semua favorit user
    public function index()
    {
        $userID = Auth::user()->id;

        $favorites = Favorite::with(['property.propertyCategories'])
            ->where('user_id', $userID)
            ->get();

        return view('favorites.index', compact('favorites'));
    }

    public function toggle($propertyId)
    {
        $userId = Auth::id();
        $exists = Favorite::where('user_id', $userId)->where('property_id', $propertyId)->exists();
        if ($exists) {
            Favorite::where('user_id', $userId)->where('property_id', $propertyId)->delete();
            return back()->with('success', 'Removed from favorites');
        }
            Favorite::create(['user_id' => $userId, 'property_id' => $propertyId]);
            return back()->with('success', 'Added to favorites');
    }
}
