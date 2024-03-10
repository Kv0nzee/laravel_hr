<?php
namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class EmployeeController extends Controller
{
    public function index()
    {
        if(\request()->ajax()) {
            $data = User::with('department'); 
            return DataTables::of($data)
                ->filterColumn('department_name', function($query, $keyword){
                    $query->whereHas('department', function($query) use ($keyword) {
                        $query->where('title', 'like', '%' .$keyword. '%');
                    });
                })
                ->addColumn('department_name', function($each){
                    return $each->department ? $each->department->title : '-';
                })
                ->editColumn('updated_at', function($each){
                    return Carbon::parse($each->updated_at)->format('Y-m-d H:i:s');
                })
                ->editColumn('profile_img', function($each){
                    if ($each->profile_img) {
                        return '<div class="flex flex-col items-center" style="width:100px; height:100px;"> 
                                    <img src="' . asset('storage/' . $each->profile_img) . '" alt="profile image" class="object-contain w-full rounded-full"">
                                    <p>'. $each->name .'</p>
                                </div>';
                    } else {
                        return $each->name;
                    }
                })
                ->editColumn('is_present', function($each){
                    if($each->is_present === "Yes"){
                        return '<span class="text-success">Present</span>';
                    }else{
                        return '<span class="text-danger">Leave</span>';
                    }
                })
                ->addColumn('action', function($each) {
                    $editBtn = '<a href="/employee/' . $each->id . '/edit" class="edit btn btn-sm"><i class="text-success bi bi-pencil-square"></i></a>';
                    $deleteBtn = '<a href="#" data-id="'. $each->id .'" class="delete btn btn-sm"><i class="text-danger bi bi-trash"></i></a>';
                    $detailBtn = '<a href="/employee/' . $each->id . '/info" class="detail btn btn-sm"><i class="bi text-info bi-info-square"></i></a>';
                    return "<div class='flex justify-between btnflex'>". $detailBtn . $editBtn . ' ' . $deleteBtn ."</div>";
                })
                        
                ->addColumn('plus-icon', function($each){
                    return '<i class="bi bi-plus"></i>';
                })
                ->rawColumns(['action', 'is_present', 'plus-icon', 'profile_img'])
                ->make(true);
        }
        return view('employee.index');
    }

    public function show($id){
        $user = User::findOrFail($id);
        return view('employee.detail', [
            "user" => $user
        ]);
    }

    public function createView(){
        $departments = Department::orderBy('title')->get();
        return view('employee.create', [
            'departments' => $departments
        ]);
    }
    
    // Controller method for storing a new employee record
    public function store(Request $request)
    {
        $formData = $request->validate([
            'employee_id' => ['required', 'integer', 'unique:users,employee_id'],
            'name' => ['required', 'max:255', 'min:5', Rule::unique('users', 'name')],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'min:8'],
            'phone' => ['required', 'regex:/[0-9]{11}/', Rule::unique('users', 'phone')],
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
        $formData['password'] = Hash::make( $formData['password'] );
        // Convert date format for birthday and date_of_join fields
        $formData['birthday'] = Carbon::createFromFormat('m/d/Y', $formData['birthday'])->format('Y-m-d');
        $formData['date_of_join'] = Carbon::createFromFormat('m/d/Y', $formData['date_of_join'])->format('Y-m-d');
        $user = User::create($formData);
        
        return redirect('/employee')->with('success',  'Employee' . $user->name . ' created successfully');    
    }

    public function edit($id){
        $user = User::findOrFail($id);
        $user->birthday = Carbon::parse($user->birthday)->format('m/d/Y');
        $user->date_of_join = Carbon::parse($user->date_of_join)->format('m/d/Y');
        
        $departments = Department::orderBy('title')->get();
        return view('employee.edit', [
            'user' => $user,
            'departments' => $departments
        ]);
    }    

    public function update(Request $request, $id){
        $user = User::findorFail($id);
        $formData = $request->validate([
            'employee_id' => ['required', 'integer', 'unique:users,employee_id,' . $user->id],
            'name' => ['required', 'max:255', 'min:5', Rule::unique('users', 'name')->ignore($user->id)],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'phone' => ['required', 'regex:/[0-9]{11}/', Rule::unique('users', 'phone')->ignore($user->id)],
            'nrc_number' => ['required'],
            'birthday' => ['required', 'date'],
            'gender' => ['required', Rule::in(['Male', 'Female'])],
            'address' => ['required'],
            'department_id' => ['required', 'exists:departments,id'], 
            'is_present' => ['required', Rule::in(['Yes', 'No'])],
            'date_of_join' => ['required', 'date'], 
        ], [
            'phone.regex' => 'The phone number must be 11 digits long and contain only numbers.',
        ]);    
        if ($request->hasFile('profile_img')) {
            // Store the new profile image and update the profile_img field
            $formData['profile_img'] = $request->file('profile_img')->store('images');
    
            // Delete the previous profile image if it exists
            if ($user->profile_img) {
                Storage::delete($user->profile_img);
            }
        }
        // Check if password is provided and not empty
        if ($request->filled('password')) {
            $formData['password'] = Hash::make($request->password);
        } else {
            $formData['password'] = Hash::make($user->password);
        }

        $formData['birthday'] = Carbon::createFromFormat('m/d/Y', $formData['birthday'])->format('Y-m-d');
        $formData['date_of_join'] = Carbon::createFromFormat('m/d/Y', $formData['date_of_join'])->format('Y-m-d');

        $user->update($formData);

        return redirect('/employee')->with('success', 'Employee updated: ' . $user->name . ' successfully');    
    }

    public function delete($id){
        try {
            $user = User::findOrFail($id);
            if ($user->profile_img) {
                Storage::delete($user->profile_img);
            }
            $user->delete();
    
            return redirect('/employee');  
        } catch (\Exception $e) {
            return redirect('/employee');
        }
    }    

}

