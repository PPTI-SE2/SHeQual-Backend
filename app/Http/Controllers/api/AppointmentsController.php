<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Appointments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentsController extends Controller
{
    public function store(Request $req){
        $app = new Appointments();

        $app->users_id = $req->get('users_id');
        $app->consultants_id = $req->get('consultants_id');
        $app->date = $req->get('date');
        $app->day = $req->get('day');
        $app->time = $req->get('time');
        $app->status = 'upcoming';
        $app->save();
        
        return ResponseFormatter::success($app, 'mantap kali kau bg');
    }
}
