<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Appointments;
use App\Models\Consultant;
use App\Models\User;
use Illuminate\Contracts\Validation\Validator as ValidationValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AppointmentsController extends Controller
{
    public function store(Request $req){
        $app = new Appointments();

        $users_id = $req->input('users_id');
        $consultants_id = $req->input('consultants_id');
        $date = $req->input('date');        
        $time = $req->input('time');

        $consultant = User::find($consultants_id);

        if (!$consultant) {
        return ResponseFormatter::error(null, 'Konsultan tidak ditemukan.');
        }        

        if ($consultant->type != 'consultant') { 
        return ResponseFormatter::error(null, 'Hanya dengan konsultant bisa membuat appointment.');
        }

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
        })->pluck('id');
        $consultator = Consultant::with('user')->whereIn('users_id', $consultantfree)->get();

        return ResponseFormatter::success($consultator, 'mantap kau bg');
    }

    public function getAppointment(Request $r){
        $userId = $r->get('users_id');

        $appointments = Appointments::where('users_id', '=', $userId)
                            ->select('id', 'date', 'time', 'status', 'message', 'consultants_id')
                            ->with('consultant')
                            ->orderBy(DB::raw('CAST(CONCAT(date, " ", time) AS DATETIME)'), 'asc')
                            ->get();

        $transformedAppointments = $appointments->map(function ($appointment) {
            return [
                'id' => $appointment->id,
                'date' => $appointment->date,
                'time' => $appointment->time,
                'status' => $appointment->status,
                'message' => $appointment->message,
                'consultant' => $appointment->consultant->name,
            ];
        });
        return ResponseFormatter::success($transformedAppointments, 'mantap');
    }
    
    public function putPayAppointment(Request $r){
        $appointmentId = $r->input('appointment_id');
        $appointment = Appointments::find($appointmentId)->get();

        $userId = $appointment->users_id;
        $consultantId = $appointment->consultants_id;

        $user = User::find($userId)->get();
        $consultant = User::find($consultantId)->get();

        if($user->poin >= 100){
            $user->poin-=100;
            $consultant->poin+=100;
            $appointment->isBayar = true;
            $user->save();
            $appointment->save();
            $consultant->save();
            return ResponseFormatter::success($appointment, 'success bang mantap');
        }

        return ResponseFormatter::error(null, 'poin kau miskin kali bang');
    }

    public function cancellAppointment(Request $r){
        $appointmentId = $r->input('appointment_id');
        $appointment = Appointments::find($appointmentId)->get();

        $appointment->status = 'cancelled';
        $appointment->save();

        return ResponseFormatter::success($appointment, 'sudah');
    }

    public function consultantBooking(Request $r){
        $userId = $r->get('consultants_id');
        $currentTime = now();

        $appointments = Appointments::where('consultants_id', '=', $userId)
                            ->where('status', '=', 'pending')
                            ->where('date', '<', $currentTime->format('Y-m-d'))
                            ->orWhere(function ($query) use ($currentTime, $userId) {
                            $query->where('date', '=', $currentTime->format('Y-m-d'))
                                    ->where('time', '<', $currentTime->format('H:i'))
                                    ->where('status', '=', 'pending');
                            })
                            ->update(['status' => 'cancelled', 'message' => 'Consultant tidak menanggapi appoinment anda']);


        $groupedAppointments = Appointments::where('consultants_id', '=', $userId)
                            ->where('status', '=', 'pending')
                            ->get()->toArray();

        $groupedAppointments = array_reduce($groupedAppointments, function ($carry, $appointment) {
            $date = date('Y-m-d', strtotime($appointment['date']));
            $time = $appointment['time'];
            $carry[$date][$time][] = $appointment;
            return $carry;
        }, []);

        return ResponseFormatter::success($groupedAppointments, 'panik kau dek');

    }

    public function consultantConfirmed(Request $r){
        $appointmentId = $r->input('appointment_id');
        
        $appointment = Appointments::find($appointmentId);

        if ($appointment) {
            $appointment->status = 'accept';
            $appointment->save();
            
            $date = $appointment->date;
            $time = $appointment->time;
            
            $cancelledCount = Appointments::where('date', '=', $date)
                                ->where('time', '=', $time)
                                ->where('id', '<>', $appointmentId)
                                ->where('status', '!=', 'accept')
                                ->update([
                                    'status' => 'cancelled',
                                    'message' => $r->input('message'),
                                ]);

            return ResponseFormatter::success(['accept' => $appointment, 'cancelled' => $cancelledCount], 'Appointments updated successfully!');
        } else {
            return ResponseFormatter::error(null, 'Appointment not found.');
        }
    }

    public function mentalList(Request $r){
        $userId = $r->get('consultants_id');
        $currentTime = now();

        $appointments = Appointments::where('consultants_id', '=', $userId)
                            ->where('status', '=', 'accept')->where('isBayar', '=', true)
                            ->where('date', '<', $currentTime->format('Y-m-d'))
                            ->orWhere(function ($query) use ($currentTime, $userId) {
                            $query->where('date', '=', $currentTime->format('Y-m-d'))
                                    ->where('time', '<', $currentTime->format('H:i'));
                            })
                            ->update(['status' => 'done']);

        $groupedAppointments = Appointments::where('consultants_id', '=', $userId)
                            ->where('status', '=', 'accept')->where('isBayar', '=', true)
                            ->get()->toArray();
                                                        
        $groupedAppointments = array_reduce($groupedAppointments, function ($carry, $appointment) {
            $date = date('Y-m-d', strtotime($appointment['date']));
            $time = $appointment['time'];
            $carry[$date][$time][] = $appointment;
            return $carry;
        }, []);

        return ResponseFormatter::success($groupedAppointments, 'panik kau dek');
    }

    
}
