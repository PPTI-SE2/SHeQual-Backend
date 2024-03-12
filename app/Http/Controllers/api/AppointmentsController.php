<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Appointments;
use App\Models\User;
use Illuminate\Contracts\Validation\Validator as ValidationValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AppointmentsController extends Controller
{
    public function store(Request $req){
        $app = new Appointments();

        $app->users_id = $req->input('users_id');
        $app->consultants_id = $req->input('consultants_id');
        $app->date = $req->input('date');        
        $app->time = $req->input('time');
        $app->status = 'pending';
        $app->save();
        
        return ResponseFormatter::success($app, 'mantap kali kau bg');

        //pending -> orderan masuk
        //confirmed -> orderan diacc consultant
        //done -> orderan selesai
        //cancelled -> dicancel consultant
    }

    public function getConsultant(Request $r){
        $time = $r->get('time');
        $date = $r->get('date');

        $consultantfree = User::where('type', '=', 'consultant')->where(function ($query) use ($time, $date) {
        $query->whereDoesntHave('appointments', function ($query) use ($time, $date) {
            $query->where('time', '=', $time)->where('date', '=', $date);
        })->orWhereHas('appointments', function ($query) use ($time, $date) {
            $query->where('time', '=', $time)->where('date', '=', $date)->where('status', '=', 'pending');
        });
    })
    ->get();

        return ResponseFormatter::success($consultantfree, 'mantap kau bg');
    }

    public function getAppointment(Request $r){ //buat liat history dari user
        $userId = $r->get('users_id');
        $allAppointment = Appointments::where('users_id', '=', $userId)->get();

        return ResponseFormatter::success($allAppointment, 'mantap');
    }
    
    public function putPayAppointment(Request $r){
        $id = $r->input('user_id');
        $user = User::find($id);
        
        if($user->poin >= 100){
            $user->poin-=100;
            $user->save();
            return ResponseFormatter::success(null, 'mantap');
        }

        return ResponseFormatter::error(null, 'poin tdk cukup');        
    }
}
