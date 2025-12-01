<?php
namespace App\Http\Controllers;

use App\Models\Property;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil 8 data per halaman
        $properties = Property::paginate(8);
        // dd(config('session.driver'));
        return view('home', compact('properties'));
    }
}