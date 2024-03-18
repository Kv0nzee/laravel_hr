<?php

namespace App\Http\Controllers;

use App\Models\CheckinCheckout;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class AttendanceController extends Controller
{
    public function index()
    {
        if(\request()->ajax()) {
            $data = CheckinCheckout::with('employee'); // Eager load the 'employee' relationship
            return DataTables::of($data)
                ->editColumn('updated_at', function($each){
                    return Carbon::parse($each->updated_at)->format('Y-m-d H:i:s');
                })
                ->editColumn('checkout_time', function($each){
                    return Carbon::parse($each->updated_at)->format('H:i:s');
                })
                ->editColumn('checkin_time', function($each){
                    return Carbon::parse($each->updated_at)->format('H:i:s');
                })
                ->addColumn('employee_name', function($each){
                    return $each->employee ? $each->employee->name : '-';
                })
                ->addColumn('action', function($each) {
                    $editBtn = '';
                    $deleteBtn = '';
                    $user = auth()->user();
                
                    // Check if user has permission to edit attendance
                    if ($user->can('edit attendance')) {
                        $editBtn = '<a href="/attendance/' . $each->id . '/edit" class="edit btn btn-sm"><i class="text-success bi bi-pencil-square"></i></a>';
                    }
                
                    // Check if user has permission to delete attendance
                    if ($user->can('delete attendance')) {
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
        return view('attendance.index');
    }

    public function createView(){
        return view('permission.create');
    }

    public function store(Request $request)
    {
        $formData = $request->validate([
            'name' => ['required', 'max:255', 'min:3', Rule::unique('permissions', 'name')]
        ]);    

        $permission = Permission::create($formData);
        
        return redirect('/permission')->with('success',  $permission->name . 'Permission created: successfully');    
    }

    public function edit($id){
        $permission = Permission::findOrFail($id);
        return view('permission.edit', [
            'permission' => $permission
        ]);
    }    

    public function update(Request $request, $id){
        $permission = Permission::findOrFail($id);
        $formData = $request->validate([
            'name' => ['required', 'max:255', 'min:3', Rule::unique('permissions', 'name')]
        ]);

        $permission->update($formData);

        return redirect('/permission')->with('success', $permission->name . 'Permission created: successfully');    
    }

    public function delete($id){
        $permission = Permission::findOrFail($id);
        $permission->delete();

        return redirect('/permission');  
    }

}
