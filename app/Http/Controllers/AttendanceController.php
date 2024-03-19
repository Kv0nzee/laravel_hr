<?php

namespace App\Http\Controllers;

use App\Models\CheckinCheckout;
use App\Models\User;
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
                ->filterColumn('employee_name', function($query, $keyword){
                    $query->whereHas('employee', function($query) use ($keyword) {
                        $query->where('name', 'like', '%' .$keyword. '%');
                    });
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
        $users = User::latest()->get();
        return view('attendance.create', [
            'users' => $users
        ]);
    }

    public function store(Request $request)
{
    $formData = $request->validate([
        'user_id' => ['required', 'exists:users,id'],
        'checkin_time' => ['required', 'date_format:H:i:s'],
        'checkout_time' => ['nullable', 'date_format:H:i:s', 'after:checkin_time'],
    ]);    

    $formData['date'] = now()->format('Y-m-d');

    $checkinCheckout = CheckinCheckout::create($formData);
    
    return redirect('/attendance')->with('success', 'Check-in checkout entry created successfully');    
}


    public function edit($id){
        $attendance = CheckinCheckout::findOrFail($id);
        $users = User::latest()->get();
        return view('attendance.edit', [
            'users' => $users,
            'attendance' => $attendance
        ]);
    }    

    public function update(Request $request, $id){
        $attendance = CheckinCheckout::findOrFail($id);
        $formData = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'checkin_time' => ['required', 'date_format:H:i:s'],
            'checkout_time' => ['nullable', 'date_format:H:i:s', 'after:checkin_time'],
        ]);    

        $attendance->update($formData);

        return redirect('/attendance')->with('success', 'Check-in checkout entry edited  successfully');    
    }

    public function delete($id){
        $attendance = CheckinCheckout::findOrFail($id);
        $attendance->delete();

        return redirect('/attendance');  
    }

}