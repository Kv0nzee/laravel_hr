<?php
namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class EmployeeController extends Controller
{
    public function index()
    {
        if(\request()->ajax()) {
            $data = User::with('department'); 
            return DataTables::of($data)
                ->addColumn('department_name', function($each){
                    return $each->department ? $each->department->name : '-';
                })
                ->editColumn('is_present', function($each){
                    if($each->is_present === 1){
                        return '<span class="text-success">Present</span>';
                    }else{
                        return '<span class="text-danger">Leave</span>';
                    }
                })
                ->addColumn('action', function($row) {
                    $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';
                    return $actionBtn;
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
}

