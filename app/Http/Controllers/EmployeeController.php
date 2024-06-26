<?php
namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
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
                ->filterColumn('profile_img', function($query, $keyword){
                    $query->where('name', 'like', '%' .$keyword. '%');
                })
                ->addColumn('department_name', function($each){
                    return $each->department ? $each->department->title : '-';
                })
                ->addColumn('roles', function($each) {
                    $rolesName = '';
                    foreach ($each->roles as $role) {
                        $rolesName .= '<span class="inline-block px-3 py-1 mb-2 mr-3 text-sm font-semibold text-gray-200 bg-gray-900 rounded-full">' . $role->name . '</span>';
                    }
                
                    return $rolesName;
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
                    $editBtn = '';
                    $deleteBtn = '';
                    $detailBtn = '';
                    $user = auth()->user();
                
                    // Check if user has permission to edit employees
                    if ($user->can('edit employees')) {
                        $editBtn = '<a href="/employee/' . $each->id . '/edit" class="edit btn btn-sm"><i class="text-success bi bi-pencil-square"></i></a>';
                    }
                
                    // Check if user has permission to delete employees
                    if ($user->can('delete employees')) {
                        $deleteBtn = '<a href="#" data-id="'. $each->id .'" class="delete btn btn-sm"><i class="text-danger bi bi-trash"></i></a>';
                    }
                
                    // Check if user has permission to view employee details
                    if ($user->can('view employees')) {
                        $detailBtn = '<a href="/employee/' . $each->id . '/info" class="detail btn btn-sm"><i class="bi text-info bi-info-square"></i></a>';
                    }
                
                    return "<div class='flex justify-between btnflex'>". $detailBtn . $editBtn . ' ' . $deleteBtn ."</div>";
                })                
                        
                ->addColumn('plus-icon', function($each){
                    return '<i class="bi bi-plus"></i>';
                })
                ->rawColumns(['action', 'is_present', 'plus-icon', 'profile_img', 'roles'])
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
        $roles = Role::orderBy('name')->get();

        return view('employee.create', [
            'departments' => $departments,
            'roles' => $roles
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
            'pin_code' => ['required', 'regex:/[0-9]{6}/', Rule::unique('users', 'pin_code')],
            'birthday' => ['required', 'date'],
            'gender' => ['required', Rule::in(['Male', 'Female'])],
            'address' => ['required'],
            'department_id' => ['required', 'exists:departments,id'], 
            'is_present'=>['required',Rule::in(['Yes', 'No'])],
            'date_of_join' => ['required', 'date'], 
        ], [
            'phone.regex' => 'The phone number must be 11 digits long and contain only numbers.',
            'pin_code.regex' => 'The pin number must be 6 digits long and contain only numbers.',
        ]);    

        if ($request->hasFile('profile_img')) {
            $formData['profile_img'] = $request->file('profile_img')->store('images');
        }
        if ($request->filled('pin_code')) {
            $existingUser = User::where('pin_code', Hash::make($request->pin_code))->first();
            if ($existingUser) {
                return redirect()->back()->withErrors(['pin_code' => 'The pin code has already been taken.'])->withInput();
            }
        }
        $formData['password'] = Hash::make( $formData['password'] );
        $formData['pin_code'] = Hash::make( $formData['pin_code'] );
        // Convert date format for birthday and date_of_join fields
        $formData['birthday'] = Carbon::createFromFormat('m/d/Y', $formData['birthday'])->format('Y-m-d');
        $formData['date_of_join'] = Carbon::createFromFormat('m/d/Y', $formData['date_of_join'])->format('Y-m-d');
        $user = User::create($formData);
        $user->syncRoles($request->roles);
        
        return redirect('/employee')->with('success',  'Employee' . $user->name . ' created successfully');    
    }

    public function edit($id){
        $user = User::findOrFail($id);
        $user->birthday = Carbon::parse($user->birthday)->format('m/d/Y');
        $user->date_of_join = Carbon::parse($user->date_of_join)->format('m/d/Y');
        
        $departments = Department::orderBy('title')->get();
        $roles = Role::orderBy('name')->get();
        
        return view('employee.edit', [
            'user' => $user,
            'departments' => $departments,
            'roles' => $roles
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
            'pin_code' => ['regex:/[0-9]{6}/'],
            'birthday' => ['required', 'date'],
            'gender' => ['required', Rule::in(['Male', 'Female'])],
            'address' => ['required'],
            'department_id' => ['required', 'exists:departments,id'], 
            'is_present' => ['required', Rule::in(['Yes', 'No'])],
            'date_of_join' => ['required', 'date'], 
        ], [
            'phone.regex' => 'The phone number must be 11 digits long and contain only numbers.',
            'pin_code.regex' => 'The pin number must be 6 digits long and contain only numbers.',
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
            $formData['password'] = $user->password;
        }
        // Check if password is provided and not empty
        if ($request->filled('pin_code')) {
            $existingUser = User::where('pin_code', Hash::make($request->pin_code))->first();
            if ($existingUser && $existingUser->id !== $user->id) {
                return redirect()->back()->withErrors(['pin_code' => 'The pin code has already been taken.'])->withInput();
            }
            $formData['pin_code'] = Hash::make($request->pin_code);
        } else {
            $formData['pin_code'] = $user->pin_code;
        }
        $formData['birthday'] = Carbon::createFromFormat('m/d/Y', $formData['birthday'])->format('Y-m-d');
        $formData['date_of_join'] = Carbon::createFromFormat('m/d/Y', $formData['date_of_join'])->format('Y-m-d');

        $user->update($formData);
        $user->syncRoles($request->roles);

        return redirect('/employee')->with('success', 'Employee updated: ' . $user->name . ' successfully');    
    }

    public function delete($id){
        try {
            $user = User::findOrFail($id);
            if ($user->profile_img) {
                Storage::delete($user->profile_img);
            }
            
            $user->syncRoles([]);
            $user->delete();
    
            return redirect('/employee');  
        } catch (\Exception $e) {
            return redirect('/employee');
        }
    }    

}

