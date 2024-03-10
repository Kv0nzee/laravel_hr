<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class DepartmentController extends Controller
{
    public function index()
    {
        if(\request()->ajax()) {
            $data = Department::latest(); 
            return DataTables::of($data)
                ->editColumn('updated_at', function($each){
                    return Carbon::parse($each->updated_at)->format('Y-m-d H:i:s');
                })
                ->addColumn('action', function($each) {
                    $editBtn = '<a href="/department/' . $each->id . '/edit" class="edit btn btn-sm"><i class="text-success bi bi-pencil-square"></i></a>';
                    $deleteBtn = '<a href="#" data-id="'. $each->id .'" class="delete btn btn-sm"><i class="text-danger bi bi-trash"></i></a>';
                    return "<div class='flex justify-between btnflex'>". $editBtn . ' ' . $deleteBtn ."</div>";
                })    
                ->addColumn('plus-icon', function($each){
                    return '<i class="bi bi-plus"></i>';
                })
                ->rawColumns(['action', 'plus-icon'])
                ->make(true);
        }
        return view('department.index');
    }

    public function createView(){
        return view('department.create');
    }

    public function store(Request $request)
    {
        $formData = $request->validate([
            'title' => ['required', 'max:255', 'min:5', Rule::unique('departments', 'title')]
        ]);    

        $department = Department::create($formData);
        
        return redirect('/department')->with('success',  $department->title . 'Department created: successfully');    
    }

    public function edit($id){
        $department = Department::findOrFail($id);
        return view('department.edit', [
            'department' => $department
        ]);
    }    

    public function update(Request $request, $id){
        $department = Department::findOrFail($id);
        $formData = $request->validate([
            'title' => ['required', 'max:255', 'min:5', Rule::unique('departments', 'title')]
        ]);

        $department->update($formData);

        return redirect('/department')->with('success', $department->title . 'Department created: successfully');    
    }

    public function delete($id){
        $department = Department::findOrFail($id);
        $department->delete();

        return redirect('/employee');  
    }

}
