<?php

namespace App\Http\Controllers;

use App\Models\Salary;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class SalaryController extends Controller
{
    public function index()
    {
        if(\request()->ajax()) {
            $data = Salary::with('employee')->latest(); 
            return DataTables::of($data)
                ->filterColumn('employee_name', function($query, $keyword){
                    $query->whereHas('employee', function($query) use ($keyword) {
                        $query->where('name', 'like', '%' .$keyword. '%');
                    });
                })
                ->editColumn('amount', function($each){
                    return number_format($each->amount);
                })
                ->editColumn('updated_at', function($each){
                    return Carbon::parse($each->updated_at)->format('Y-m-d H:i:s');
                })
                ->addColumn('employee_name', function($each){
                    return $each->employee ? $each->employee->name : '-';
                })    
                ->addColumn('action', function($each) {
                    $editBtn = '';
                    $deleteBtn = '';
                    $user = auth()->user();
                
                    // Check if user has permission to edit Salarys
                    if ($user->can('edit salary')) {
                        $editBtn = '<a href="/salary/' . $each->id . '/edit" class="edit btn btn-sm"><i class="text-success bi bi-pencil-square"></i></a>';
                    }
                
                    // Check if user has permission to delete Salarys
                    if ($user->can('delete salary')) {
                        $deleteBtn = '<a href="#" data-id="'. $each->id .'" class="delete btn btn-sm"><i class="text-danger bi bi-trash"></i></a>';
                    }
                
                    return "<div class='flex justify-between btnflex'>". $editBtn . ' ' . $deleteBtn ."</div>";
                })
                ->addColumn('plus-icon', function($each){
                    return '<i class="bi bi-plus"></i>';
                })
                ->rawColumns(['action', 'plus-icon'])
                ->make(true);
        }
        return view('salary.index');
    }

    public function createView(){
        $employees = User::all();

        return view('salary.create', [
            'employees' => $employees
        ]);
    }

    public function store(Request $request)
    {
        $formData = $request->validate([
            'employee_names.*' => ['required', 'exists:users,id'], 
            'month' => [
                'required',
                'date_format:Y-m',
                Rule::unique('salaries')->where(function ($query) use ($request) {
                    return $query->where('month', $request->input('month'))
                                 ->whereIn('user_id', $request->input('employee_names'));
                }),
            ],
            'amount' => ['required', 'numeric', 'min:100000'],
        ]);    
    
        foreach ($formData['employee_names'] as $employeeId) {
            $salaryData = [
                'user_id' => $employeeId,
                'month' => $formData['month'],
                'amount' => $formData['amount'],
            ];
    
            Salary::create($salaryData);
        }
        
        return redirect('/salary')->with('success', 'Salaries created successfully');
    }

    public function edit($id){
        $Salary = Salary::findOrFail($id);
        $employees = User::all();
        return view('Salary.edit', [
            'salary' => $Salary,
            'employees' => $employees
        ]);
    }    

    public function update(Request $request, $id){
        $salary = Salary::findOrFail($id);
        $formData = $request->validate([
            'employee_names.*' => ['required', 'exists:users,id'], 
            'month' => [
                'required',
                'date_format:Y-m',
                Rule::unique('salaries')->ignore($salary->id)->where(function ($query) use ($request) {
                    return $query->where('month', $request->input('month'))
                                 ->whereIn('user_id', $request->input('employee_names'));
                }),
            ],
            'amount' => ['required', 'numeric', 'min:100000'],
        ]);    

        foreach ($formData['employee_names'] as $employeeId) {
            $salaryData = [
                'user_id' => $employeeId,
                'month' => $formData['month'],
                'amount' => $formData['amount'],
            ];

            $salary->update($salaryData);
        }

        return redirect('/salary')->with('success', 'Salary Edited: successfully');    
    }

    public function delete($id){
        $salary = Salary::findOrFail($id);
        $salary->delete();

        return redirect('/salary');  
    }

}
