<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AuthUserController extends Controller
{
   public function login(){
    return view('auth.login');
   }

   public function register(){
    return view('auth.register');
   }

   public function store(){

      $formData = request()->validate([
         'name'=>['required', 'max:255', 'min:5', Rule::unique('users', 'name')],
         'email'=>['required', 'email', Rule::unique('users', 'email')],
         'password'=>['required','min:8', 'same:confirm_Password']
      ]);

      $user = User::create($formData);

      auth()->login($user);

      return redirect('/')->with('success', 'Welcome  '.$user->name);

   }

   public function post_login(){
      $formData = request()->validate([
         'email'=>['required', 'email','max:255', 'min:5'],
         'password'=>['required','min:8']
      ]);

      if(auth()->attempt($formData)){
         return redirect('/')->with('success', 'Welcome  '.auth()->user()->name);
      }else{
         return redirect()->back()->withErrors([
            'password'=>'User Credentials Wrong'
         ]);
      }
   }

   public function logout(){
      auth()->logout();
      return redirect('/')->with('success', "Successfully logout");
   }
}
