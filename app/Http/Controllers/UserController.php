<?php

namespace App\Http\Controllers;

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

    public function checkin(){
        $user = auth()->user();
        return view('profile.checkin', [
            'user'=> $user
        ]);
    }

    public function checkPinCode(Request $request)
    {
        $validatedData = $request->validate([
            'code' => 'required|string|min:6|max:6',
        ]);

        $userPinCode = auth()->user()->pin_code;

        // Check if the provided code matches the hashed pin code
        if (Hash::check($validatedData['code'], $userPinCode)) {
            return response()->json(['success' => true], 200);
        } else {
            return response()->json(['success' => false], 422);
        }
    }
}
