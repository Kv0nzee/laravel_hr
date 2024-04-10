<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class ProjectController extends Controller
{
    public function index()
    {
        if(\request()->ajax()) {
            $data = Project::latest(); 
            return DataTables::of($data)
                ->filterColumn('images', function($query, $keyword){
                        $query->where('title', 'like', '%' .$keyword. '%');
                })
                ->editColumn('updated_at', function($each){
                    return Carbon::parse($each->updated_at)->format('Y-m-d H:i:s');
                })
                ->editColumn('images', function($each){
                    if ($each->images) {
                        $html = '<div>  <p class="font-bold text-md">'. $each->title .'</p><div class="flex flex-wrap">';
                        foreach ($each->images as $image) {
                            $html .= '<div class="w-32 h-32 m-2 overflow-hidden bg-gray-200 rounded-lg shadow-md">
                                        <img src="' . asset('storage/' . $image) . '" alt="profile image" class="object-cover w-full h-full">
                                      </div>';
                        }
                      
                        $html .= '</div>';
                        return $html;
                    } else {
                        return $each->title;
                    }
                })                
                ->editColumn('start_date', function($each){
                    return Carbon::parse($each->updated_at)->format('d-m-Y ');
                })
                ->editColumn('deadline', function($each){
                    return Carbon::parse($each->updated_at)->format('d-m-Y ');
                })
                ->addColumn('action', function($each) {
                    $editBtn = '';
                    $deleteBtn = '';
                    $user = auth()->user();
                
                    // Check if user has permission to edit Projects
                    if ($user->can('edit projects')) {
                        $editBtn = '<a href="/project/' . $each->id . '/edit" class="edit btn btn-sm"><i class="text-success bi bi-pencil-square"></i></a>';
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
                ->rawColumns(['action', 'plus-icon', 'images'])
                ->make(true);
        }
        return view('project.index');
    }

    public function createView(){
        return view('project.create');
    }
    public function store(Request $request)
    {
        // Validate the request data
        $formData = $request->validate([
            'title' => ['required', 'max:255', 'min:5', Rule::unique('projects', 'title')],
            'description' => ['nullable', 'string'],
            'start_date' => ['nullable', 'date_format:Y/m/d'],
            'deadline' => ['nullable', 'date_format:Y/m/d', 'after_or_equal:start_date'],
            'priority' => ['required', 'string', Rule::in(['High', 'Middle', 'Low'])],
            'status' => ['required', 'string', Rule::in(['Pending', 'In Progress', 'Complete'])],
        ]);
    
        // Store uploaded files (profile images and PDF documents)
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('projects', 'public');
            }
        }
    
        $pdfPaths = [];
        if ($request->hasFile('pdf_files')) {
            foreach ($request->file('pdf_files') as $pdf) {
                $pdfPaths[] = $pdf->store('pdf_documents', 'public');
            }
        }
    
        // Create a new Project instance
        $project = new Project();
        $project->title = $formData['title'];
        $project->description = $formData['description'];
        $project->images = $imagePaths;
        $project->files = $pdfPaths;
        $project->start_date = $formData['start_date'];
        $project->deadline = $formData['deadline'];
        $project->priority = $formData['priority'];
        $project->status = $formData['status'];
    
        // Save the Project to the database
        $project->save();
        
        return redirect('/project')->with('success', $project->title . ' Project created successfully');
    }    

    public function edit($id){
        $project = Project::findOrFail($id);
        return view('project.edit', [
            'project' => $project
        ]);
    }    

    public function update(Request $request, $id){
        $Project = Project::findOrFail($id);
        // Validate the request data
        $formData = $request->validate([
            'title' => ['required', 'max:255', 'min:5', Rule::unique('projects', 'title')->ignore($Project->id)],
            'description' => ['nullable', 'string'],
            'start_date' => ['nullable', 'date_format:Y/m/d'],
            'deadline' => ['nullable', 'date_format:Y/m/d', 'after_or_equal:start_date'],
            'priority' => ['required', 'string', Rule::in(['High', 'Middle', 'Low'])],
            'status' => ['required', 'string', Rule::in(['Pending', 'In Progress', 'Complete'])],
        ]);
    
        // Store uploaded files (profile images and PDF documents)
        $imagePaths = $Project->images;
        if ($request->hasFile('images')) {
            // Remove previous image files
            Storage::disk('public')->delete($imagePaths);

            // Store new image files
            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('projects', 'public');
            }
        }

        $pdfPaths = $Project->files;
        if ($request->hasFile('pdf_files')) {
            // Remove previous PDF files
            Storage::disk('public')->delete($pdfPaths);

            // Store new PDF files
            $pdfPaths = [];
            foreach ($request->file('pdf_files') as $pdf) {
                $pdfPaths[] = $pdf->store('pdf_documents', 'public');
            }
        }
    
        $formData['images'] = $imagePaths;
        $formData['files'] = $pdfPaths;
    
        // Save the Project to the database
        $Project->update($formData);
        return redirect('/project')->with('success', $Project->title . 'Project updated: successfully');    
    }

    public function delete($id){
        $Project = Project::findOrFail($id);
        $Project->delete();

        return redirect('/project');  
    }

}
