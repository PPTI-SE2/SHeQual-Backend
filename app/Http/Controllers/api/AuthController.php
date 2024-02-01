<?php

namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use Auth;

class AuthController extends Controller
{
    public function register(Request $request){
        $validator = Validator::make($request ->all(),[
            'name'=> 'required',
            'age' => 'required',
            'username' => 'required',
            'email' => 'required|email',
            'password'=>'required',
            'confirm_password'=>'required|same:password'
        ]);


        if($validator->fails()){
            return response()->json([
                'succes'=>false,
                'message'=>'salah',
                'data'=>$validator->errors()
            ]);
        }
        $input = $request->all();
        $input['password']= bcrypt($input['password']);
        $user = User::create($input);

        // buat token

        $succes['token'] = $user->createToken('auth_token')->plainTextToken;
        $succes['name'] = $user->name;

        return response()->json([
            'succes'=> true,
            'message'=> 'sukses bang congcrats',
            'data'=> $succes
        ])->withHeaders([
                'X-CSRF-TOKEN' => csrf_token()
            ]);

    }

    public function login(Request $request){

        //NYOBA
        // $validator = Validator::make($request ->all(),[
        //      'email' => 'required']);
        //NYOBA

        if(Auth::attempt(['email'=> $request->email,'password' =>$request->password])){
            $auth = Auth::user();
            $success['token'] = $auth->createToken('auth_token')->plainTextToken;
            $success['name'] =$auth->name;


            return response()->json([
                'succes'=>true,
                'message'=>'Login sukses',
                'data'=>$success
            ])->withHeaders([
                'X-CSRF-TOKEN' => csrf_token()
            ]);

        }else{

            //  $validator = Validator::make($request ->all(),[
            //  'email' => 'required']);
                return response()->json([
                'succes'=>false,
                'message'=>'Password Salah, Cek Lagi',
                'data'=> null
            ]);
        }

    }
}
