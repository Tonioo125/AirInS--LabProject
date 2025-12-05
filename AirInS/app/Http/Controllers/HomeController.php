<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $properties = Property::paginate(8);

        if (Auth::check()) {
            $userID = Auth::user()->id;

            $favoriteIDs = Favorite::where('user_id', $userID)
                ->pluck('property_id')
                ->toArray();

            foreach ($properties as $property) {
                $property->is_favorited = in_array($property->id, $favoriteIDs);
            }
        } else {
            foreach ($properties as $property) {
                $property->is_favorited = false;
            }
        }

        return view('home', compact('properties'));
    }
}