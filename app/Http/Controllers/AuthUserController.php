<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AuthUserController extends Controller
{
   public function login(){
    return view('auth.login');
   }

   public function register(){
    $departments = Department::orderBy('title')->get();
    return view('auth.register', [
      'departments' => $departments
    ]);
   }

   public function store(Request $request){

      $formData = $request->validate([
         'employee_id' => ['required', 'integer', 'unique:users,employee_id'],
         'name' => ['required', 'max:255', 'min:5', Rule::unique('users', 'name')],
         'email' => ['required', 'email', Rule::unique('users', 'email')],
         'password' => ['required', 'min:8', 'same:confirm_password'],
         'phone' => ['required', 'regex:/[0-9]{11}/'],
         'nrc_number' => ['required'],
         'birthday' => ['required', 'date'],
         'gender' => ['required', Rule::in(['Male', 'Female'])],
         'address' => ['required'],
         'department_id' => ['required', 'exists:departments,id'], 
         'is_present'=>['required',Rule::in(['Yes', 'No'])],
         'date_of_join' => ['required', 'date'], 
     ], [
         'phone.regex' => 'The phone number must be 11 digits long and contain only numbers.',
     ]);     

     if ($request->hasFile('profile_img')) {
            $formData['profile_img'] = $request->file('profile_img')->store('images');
      }
      // Convert date format for birthday and date_of_join fields
      $formData['birthday'] = Carbon::createFromFormat('m/d/Y', $formData['birthday'])->format('Y-m-d');
      $formData['date_of_join'] = Carbon::createFromFormat('m/d/Y', $formData['date_of_join'])->format('Y-m-d');
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
