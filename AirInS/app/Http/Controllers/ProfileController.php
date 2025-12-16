<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AirUser;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        // dd(get_class(Auth::user()));
        return view('profile.index', compact('user'));
    }

    public function update(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to update your profile.');
        }

        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:5',
            'email' => 'required|email|max:50',
            'phone' => 'nullable|string|max:20',
            'gender' => 'nullable|string|max:6',
        ]);

        AirUser::where('id', $user->id)->update($request->only(['name', 'email', 'phone', 'gender']));

        return redirect()->route('profile.index')->with('success', 'Profile updated successfully.');
    }
}
