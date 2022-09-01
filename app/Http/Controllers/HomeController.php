<?php

namespace App\Http\Controllers;

use App\Models\Lab;
use App\Models\LabsSchedule;
use App\Models\Reservation;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $labs = Lab::get();
        if (auth()->user()->hasRole(config('role.admin'))) {
            return view('home.admin', compact('labs'));
        } else {
            return view('home.user', compact('labs'));
        }
    }
}
