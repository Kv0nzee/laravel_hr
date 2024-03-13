<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class RoleController extends Controller
{
    public function index()
    {
        if(\request()->ajax()) {
            $data = Role::with('permissions')->latest(); // Assuming 'permissions' is the relationship name
            return DataTables::of($data)
                ->editColumn('updated_at', function($each){
                    return Carbon::parse($each->updated_at)->format('Y-m-d H:i:s');
                })
                ->addColumn('action', function($each) {
                    $editBtn = '';
                    $deleteBtn = '';
                    $user = auth()->user();
                
                    // Check if user has permission to edit roles
                    if ($user->can('edit roles')) {
                        $editBtn = '<a href="/role/' . $each->id . '/edit" class="edit btn btn-sm"><i class="text-success bi bi-pencil-square"></i></a>';
                    }
                
                    // Check if user has permission to delete roles
                    if ($user->can('delete roles')) {
                        $deleteBtn = '<a href="#" data-id="'. $each->id .'" class="delete btn btn-sm"><i class="text-danger bi bi-trash"></i></a>';
                    }
                
                    return "<div class='flex justify-between btnflex'>". $editBtn . ' ' . $deleteBtn ."</div>";
                })                
                ->addColumn('permissions', function($each) {
                    $permissionNames = $each->permissions->pluck('name')->toArray();
                    $tags = '';
                
                    foreach ($permissionNames as $permission) {
                        $tags .= '<span class="inline-block px-3 py-1 mb-2 mr-3 text-sm font-semibold text-gray-200 bg-gray-900 rounded-full">' . $permission . '</span>';
                    }
                
                    return $tags;
                })                
                ->addColumn('plus-icon', function($each){
                    return '<i class="bi bi-plus"></i>';
                })
                ->rawColumns(['action', 'permissions', 'plus-icon'])
                ->make(true);
        }
        return view('role.index');
    }


    public function createView(){
        $permissions = Permission::all();
        return view('role.create', [
            "permissions"=> $permissions
        ]);
    }

    public function store(Request $request)
    {
        $formData = $request->validate([
            'name' => ['required', 'max:255', 'min:3', Rule::unique('roles', 'name')]
        ]);    

        $role = Role::create($formData);
        $role->givePermissionTo($request->permissions);
        
        return redirect('/role')->with('success',  $role->name . 'Role created: successfully');    
    }

    public function edit($id){
        $role = Role::findOrFail($id);
        $permissions = Permission::all();
        return view('role.edit', [
            'role' => $role,
            "permissions"=> $permissions
        ]);
    }    

    public function update(Request $request, $id){
        $role = Role::findOrFail($id);
        $formData = $request->validate([
            'name' => ['required', 'max:255', 'min:3', Rule::unique('roles', 'name')->ignore($role->id)]
        ]);

        $role->update($formData);
        $role->syncPermissions($request->permissions);

        return redirect('/role')->with('success', $role->name . 'Role created: successfully');    
    }

    public function delete($id){
        $role = Role::findOrFail($id);
        $role->revokePermissionTo($role->permissions);
        $role->delete();

        return redirect('/role');  
    }

}
