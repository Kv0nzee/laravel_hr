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
                ->editColumn('is_present', function($each){
                    if($each->is_present === "Yes"){
                        return '<span class="text-success">Present</span>';
                    }else{
                        return '<span class="text-danger">Leave</span>';
                    }
                })
                ->editColumn('updated_at', function($each){
                    return Carbon::parse($each->updated_at)->format('Y-m-d H:i:s');
                })
                ->addColumn('action', function($row) {
                    $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';
                    return $actionBtn;
                })
                ->addColumn('plus-icon', function($row){
                    return null;
                })
                ->rawColumns(['action', 'is_present'])
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

}

