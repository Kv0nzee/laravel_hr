<?php
namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class EmployeeController extends Controller
{
    public function index()
    {
        if(\request()->ajax()) {
            $data = User::with('department'); 
            return DataTables::of($data)
                ->addColumn('department_name', function($each){
                    return $each->department ? $each->department->title : '-';
                })
                ->editColumn('updated_at', function($each){
                    return Carbon::parse($each->updated_at)->format('Y-m-d H:i:s');
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
                    $deleteBtn = '<a href="javascript:void(0)" class="delete btn btn-sm"><i class="text-danger bi bi-trash"></i></a>';
                    $detailBtn = '<a href="javascript:void(0)" class="detail btn btn-sm"><i class="bi text-info bi-info-square"></i></a>';
                    return "<div class='flex justify-between btnflex'>". $detailBtn . $editBtn . ' ' . $deleteBtn ."</div>";
                })
                        
                ->addColumn('plus-icon', function($each){
                    return '<i class="bi bi-plus"></i>';
                })
                ->rawColumns(['action', 'is_present', 'plus-icon'])
                ->make(true);
        }
        return view('employee.index');
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

        $formData['password'] = Hash::make( $formData['password'] );
        // Convert date format for birthday and date_of_join fields
        $formData['birthday'] = Carbon::createFromFormat('m/d/Y', $formData['birthday'])->format('Y-m-d');
        $formData['date_of_join'] = Carbon::createFromFormat('m/d/Y', $formData['date_of_join'])->format('Y-m-d');
        $user = User::create($formData);
        
        return redirect('/employee')->with('success', 'Employee created: ' . $user->name . '  successfully');    
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


}

