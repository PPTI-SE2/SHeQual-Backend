<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\Consultant;
use Illuminate\Support\Facades\Auth;

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

        return ResponseFormatter::success($data, 'mantap');
    }

    public function profile(User $user){
        $user  = $user -> find(Auth::user()->id);

         return response()->json([
            'name' => $user->name,
            'username' => $user->username,
            'age' => $user->age,
            'email' => $user->email
        ]);
        
    }

}
