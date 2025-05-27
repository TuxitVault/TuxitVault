<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return inertia('Profile/Edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'email' => 'required|email|unique:users,email,' . $user->id,
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'password' => 'nullable|string|min:8|confirmed', // confirmation champ password_confirmation
        ]);

        $user->email = $data['email'];
        $user->firstname = $data['firstname'];
        $user->lastname = $data['lastname'];

        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Profil mis à jour avec succès.');
    }
}
