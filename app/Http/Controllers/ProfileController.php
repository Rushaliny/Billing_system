<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show()
    {
        return view('profile', ['user' => Auth::user()]);
    }

    public function update(Request $request)
    {

    $user = auth()->user();

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'account_number' => 'nullable|string',
        'password' => 'nullable|string|min:6',
    ]);

    // Update fields
    $user->name = $validated['name'];
    $user->email = $validated['email'];
    $user->account_number = $validated['account_number'];

    // Update password only if it's provided
    if (!empty($validated['password'])) {
        $user->password = Hash::make($validated['password']);
    }

    $user->save();

    return redirect()->route('profile.show')->with('success', 'Profile updated successfully!');
    }
}
