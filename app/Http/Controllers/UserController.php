<?php

namespace App\Http\Controllers;

use App\Models\CheckinCheckout;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(){
        $user = auth()->user();
        return view('home', [
            'user'=> $user
        ]);
    }

    public function profile(){
        $user = auth()->user();
        $selectedYear = Carbon::now()->year;
        $selectedMonth = Carbon::now()->month;
        return view('profile.index', [
            'user'=> $user,
            'selectedYear' => $selectedYear,
            'selectedMonth' => $selectedMonth
            
        ]);
    }
}
