<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\users;

class EditprofileController extends Controller
{

   public function update(Request $request)
    {
        $request->validate([
            'img_profile' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'username' => 'nullable',
            'email' => 'nullable|email',
            'password' => 'nullable',
            'age' => 'nullable'
        ]);

        $dataUser = User::findOrFail($request->id);

        // Mengunggah dan menyimpan foto profil jika diunggah
        if ($request->hasFile('img_profile')) {
            $imagePath = $request->file('img_profile')->store('profile-photos', 'public');
            $dataUser->img_profile = $imagePath; // Menyimpan path gambar ke model pengguna
        }

        // Update atribut lainnya seperti username, email, password, dll.
        if ($request->filled('username')) {
            $dataUser->username = $request->username;
        }

        if ($request->filled('age')) {
            $dataUser->age = $request->age;
        }

        if ($request->filled('email')) {
            $dataUser->email = $request->email;
        }

        if ($request->filled('password')) {
            $dataUser->password = bcrypt($request->password);
        }


        $dataUser->save();

        return ResponseFormatter::success($dataUser, "Data berhasil diperbaharui");
    }


}
