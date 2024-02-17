<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EditProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $user->update($request->only(['name', 'email'])); // Sesuaikan dengan kolom yang ingin diubah

        return redirect('/profile/edit')->with('success', 'Profile updated successfully');
    }
}
