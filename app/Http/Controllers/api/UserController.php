<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

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
}
