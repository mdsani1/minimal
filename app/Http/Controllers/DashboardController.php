<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Land;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = User::where('id', Auth()->user()->id)->first();

        if($user->role_id == 1 || $user->role_id == 2){
            return view('backend.dashboard');
        }
        else{
            return view('welcome');
        }
    }
}