<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Auth; #coba

class UserController extends Controller
{
    public function index(){
        $users = User::all();

        $data = $users->map(function ($user){
           return[
                'id' => $user->id,
                'username' => $user->username,
                'age' => $user->age
           ];
        });

        return response()->json($data);
    }

    public function profile(User $user){
        $user  = $user -> find(Auth::user()->id);

         return response()->json([
            'name' => $user->name,
            'username' => $user->username,
            'age' => $user->age
        ]);

    }

}
