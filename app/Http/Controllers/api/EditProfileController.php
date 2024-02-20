<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\users;

class EditProfileController extends Controller
{

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|max 50',
            'email'=> 'required|max 50',
            'password'=> 'nullable|max 8' //bisa kosong
        ]);

        if($request->password != ' '){
            $data['password'] = bcrypt($request->password);
        }else{
            unset($data['password']);
        }

        $user = auth() -> user();
        $user->fill($data);
        $user->save();
        flash('U did it :)')->success();
        return back();

    }

}
