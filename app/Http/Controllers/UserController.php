<?php

namespace App\Http\Controllers;

use App\Models\CheckinCheckout;
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
        return view('profile.index', [
            'user'=> $user
        ]);
    }
}
