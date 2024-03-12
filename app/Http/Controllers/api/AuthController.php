<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Consultant;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request){
        $validator = Validator::make($request->all(),[
            'name'=> 'required',
            'age' => 'required',
            'username' => 'required',
            'email' => 'required|email',
            'password'=>'required',
            'confirm_password'=>'required|same:password',
            'type' => 'nullable'            
        ]);


        if($validator->fails()){
            return response()->json([
                'succes'=>false,
                'message'=>'Format Salah',
                'data'=>$validator->errors()
            ]);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);

        // buat token

        $succes['token'] = $user->createToken('auth_token')->plainTextToken;
        $succes['name'] = $user->name;

        return response()->json([
            'succes'=> true,
            'message'=> 'sukses bang congcrats',
            'data' => $user,
            'token' => $succes["token"]
        ])->withHeaders([
                'X-CSRF-TOKEN' => csrf_token()
            ]);

    }

    public function makeConsultator(Request $request){
        $userId = $request->input('users_id');
        $user = User::find($userId);
        $user->type = 'consultant';
        $user->save();

        $consultant = new Consultant();
        $consultant->name = $request->input('name');
        $consultant->users_id = $userId;
        $consultant->bio = $request->input('bio');
        $consultant->save();

        return ResponseFormatter::success($consultant, 'berhasil');
    }

    public function login(Request $request){

        if(Auth::attempt(['email'=> $request->email,'password' =>$request->password])){
            $auth = Auth::user();
            $token = $auth->createToken('auth_token')->plainTextToken;


            return response()->json([
                'succes' => true,
                'message' => 'Login sukses',
                'data' => $auth,
                'token' => $token,
            ])->withHeaders([
                'X-CSRF-TOKEN' => csrf_token()
            ]);

        }else{

                return response()->json([
                'succes'=>false,
                'message'=>'Password Salah, Cek Lagi',
                'data'=> null
            ]);
        }

    }

    public function loginCon(Request $request){

        if(Auth::attempt(['username'=> $request->username,'password' =>$request->password, 'type' => 'consultant'])){
            $auth = Auth::user();
            $token = $auth->createToken('auth_token')->plainTextToken;
            $consultant = Consultant::find($auth);

            return response()->json([
                'succes' => true,
                'message' => 'Login sukses',
                'data' => $consultant,
                'token' => $token,
            ])->withHeaders([
                'X-CSRF-TOKEN' => csrf_token()
            ]);

        }else{

                return response()->json([
                'succes'=>false,
                'message'=>'Gagal Login',
                'data'=> null
            ]);
        }

    }
}
