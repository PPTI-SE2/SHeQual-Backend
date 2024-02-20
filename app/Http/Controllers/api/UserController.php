<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
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

        return ResponseFormatter::success($data, 'mantap');
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
