<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class ProjectController extends Controller
{
    public function index()
    {
        if(\request()->ajax()) {
            $data = Project::latest(); 
            return DataTables::of($data)
                ->editColumn('updated_at', function($each){
                    return Carbon::parse($each->updated_at)->format('Y-m-d H:i:s');
                })
                ->editColumn('images', function($each){
                    if ($each->images) {
                        return '<div class="flex flex-col items-center" style="width:100px; height:100px;"> 
                                    <img src="' . asset('storage/' . $each->images) . '" alt="profile image" class="object-contain w-full rounded-full"">
                                    <p>'. $each->title .'</p>
                                </div>';
                    } else {
                        return $each->title;
                    }
                })
                ->addColumn('action', function($each) {
                    $editBtn = '';
                    $deleteBtn = '';
                    $user = auth()->user();
                
                    // Check if user has permission to edit Projects
                    if ($user->can('edit projects')) {
                        $editBtn = '<a href="/Project/' . $each->id . '/edit" class="edit btn btn-sm"><i class="text-success bi bi-pencil-square"></i></a>';
                    }
                
                    // Check if user has permission to delete projects
                    if ($user->can('delete projects')) {
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
        return view('project.index');
    }

    public function createView(){
        return view('project.create');
    }

    public function store(Request $request)
    {
        $formData = $request->validate([
            'title' => ['required', 'max:255', 'min:5', Rule::unique('Projects', 'title')]
        ]);    

        $Project = Project::create($formData);
        
        return redirect('/Project')->with('success',  $Project->title . 'Project created: successfully');    
    }

    public function edit($id){
        $Project = Project::findOrFail($id);
        return view('project.edit', [
            'Project' => $Project
        ]);
    }    

    public function update(Request $request, $id){
        $Project = Project::findOrFail($id);
        $formData = $request->validate([
            'title' => ['required', 'max:255', 'min:5', Rule::unique('Projects', 'title')]
        ]);

        $Project->update($formData);

        return redirect('/Project')->with('success', $Project->title . 'Project created: successfully');    
    }

    public function delete($id){
        $Project = Project::findOrFail($id);
        $Project->delete();

        return redirect('/Project');  
    }

}
