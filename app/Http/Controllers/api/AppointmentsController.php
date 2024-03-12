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

        $users_id = $req->input('users_id');
        $consultants_id = $req->input('consultants_id');
        $date = $req->input('date');        
        $time = $req->input('time');

        $check = Appointments::where('consultants_id', '=', $consultants_id)
                                ->where('date', '=', $date)
                                ->where('time', '=', $time)
                                ->where('status', '=', 'pending')
                                ->where('users_id', '=', $users_id)->get();
        
        if($check->isEmpty()){
            $app->users_id = $req->input('users_id');
            $app->consultants_id = $req->input('consultants_id');
            $app->date = $req->input('date');        
            $app->time = $req->input('time');
            $app->status = 'pending';
            $app->save();
            return ResponseFormatter::success($app, 'mantap kali kau bg');
        }

        return ResponseFormatter::error($check, 'udah pernah request ke konsultan ini');

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
        })->get();

        // $consultantfree = User::where('type', '=', 'consultant')->whereNotIn('id', function ($query) use ($time, $date) {
        // $query->select('consultants_id')->from('appointments')
        // ->where('time', '=', $time)->where('date', '=', $date);
        // })->get();
 
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

    public function consultantBooking(Request $r){
        // $userId = $r->get('consultants_id');
        // $allAppointment = Appointments::where('consultants_id', '=', $userId)->where('status', '=', 'pending')->get();

        // return ResponseFormatter::success($allAppointment, 'mantap');
        $userId = $r->get('consultants_id');

        $appointments = Appointments::where('consultants_id', '=', $userId)->where('status', '=', 'pending')->get()->toArray();
        $groupedAppointments = array_reduce($appointments, function ($carry, $appointment) {
            $date = date('Y-m-d', strtotime($appointment['date']));
            $time = $appointment['time'];
            $carry[$date][$time][] = $appointment;
            return $carry;
        }, []);

        return ResponseFormatter::success($groupedAppointments, 'mantap');
    }

    public function consultantConfirmed(Request $r){

    }

}
