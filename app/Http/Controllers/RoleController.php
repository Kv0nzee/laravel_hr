<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class RoleController extends Controller
{
    public function index()
    {
        if(\request()->ajax()) {
            $data = Role::latest(); 
            return DataTables::of($data)
                ->editColumn('updated_at', function($each){
                    return Carbon::parse($each->updated_at)->format('Y-m-d H:i:s');
                })
                ->addColumn('action', function($each) {
                    $editBtn = '<a href="/role/' . $each->id . '/edit" class="edit btn btn-sm"><i class="text-success bi bi-pencil-square"></i></a>';
                    $deleteBtn = '<a href="#" data-id="'. $each->id .'" class="delete btn btn-sm"><i class="text-danger bi bi-trash"></i></a>';
                    return "<div class='flex justify-between btnflex'>". $editBtn . ' ' . $deleteBtn ."</div>";
                })    
                ->addColumn('plus-icon', function($each){
                    return '<i class="bi bi-plus"></i>';
                })
                ->rawColumns(['action', 'plus-icon'])
                ->make(true);
        }
        return view('role.index');
    }

    public function createView(){
        return view('role.create');
    }

    public function store(Request $request)
    {
        $formData = $request->validate([
            'name' => ['required', 'max:255', 'min:3', Rule::unique('roles', 'name')]
        ]);    

        $role = Role::create($formData);
        
        return redirect('/role')->with('success',  $role->name . 'Role created: successfully');    
    }

    public function edit($id){
        $role = Role::findOrFail($id);
        return view('role.edit', [
            'role' => $role
        ]);
    }    

    public function update(Request $request, $id){
        $role = Role::findOrFail($id);
        $formData = $request->validate([
            'name' => ['required', 'max:255', 'min:3', Rule::unique('roles', 'name')]
        ]);

        $role->update($formData);

        return redirect('/role')->with('success', $role->name . 'Role created: successfully');    
    }

    public function delete($id){
        $role = Role::findOrFail($id);
        $role->delete();

        return redirect('/role');  
    }

}
