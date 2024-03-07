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

    public function consul_index(){
        $consultants = Consultant::with('user')->get();

        $data = $consultants->map(function ($consultant){
            return[
                'id' => $consultant->id,
                'img_profile' => $consultant->user->img_profile,
                'username' => $consultant->user->username,
                'age' => $consultant->user->age,
                'users_id' => $consultant->users_id,
                'patients' => $consultant->patients,
                'bio_data' => $consultant->bio_data,
                'experience' => $consultant->experience,
                'status' => $consultant->status,
            ];
        });
        return ResponseFormatter::success($data, 'sip');
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
