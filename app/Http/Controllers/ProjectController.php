<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectLeader;
use App\Models\ProjectMember;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    public function index()
    {
        if(\request()->ajax()) {
            $data = Project::with('leaders', 'members'); 
            return DataTables::of($data)
                ->filterColumn('images', function($query, $keyword){
                        $query->where('title', 'like', '%' .$keyword. '%');
                })
                ->editColumn('description', function($each){
                    return Str::limit($each->description, 25);
                })
                ->editColumn('updated_at', function($each){
                    return Carbon::parse($each->updated_at)->format('Y-m-d H:i:s');
                })
                ->editColumn('images', function($each){
                    if ($each->images) {
                        $html = '<div>  <p class="font-bold text-md">'. $each->title .'</p><div class="flex flex-wrap">';
                        foreach ($each->images as $image) {
                            $html .= '<div class="w-24 h-20 m-2 overflow-hidden bg-gray-200 rounded-lg shadow-md">
                                        <img src="' . asset('storage/' . $image) . '" alt="profile image" class="object-cover w-full h-full">
                                      </div>';
                        }
                      
                        $html .= '</div>';
                        return $html;
                    } else {
                        return $each->title;
                    }
                })   
                ->addColumn('leaders', function($each){
                    $html = '<div class="flex flex-wrap items-center justify-center w-full h-full">'; 
                
                    if ($each->leaders) {
                        foreach ($each->leaders as $leader) {
                            $profileImage = $leader->profile_img ? asset('storage/' . $leader->profile_img) : asset('/storage/images/avatarlogo.jpg');
                            $html .= '<div class="w-12 h-12 m-2 overflow-hidden bg-gray-200 rounded-lg shadow-md">
                                        <img src="' . $profileImage . '" alt="profile image" class="object-cover w-full h-full">
                                    </div>';
                        }
                    }
                    $html .='</div>';
                    
                    return $html;
                }) 
                ->addColumn('members', function($each){
                    $html = '<div class="flex flex-wrap items-center justify-center w-full h-full">'; 
                
                    if ($each->members) {
                        foreach ($each->members as $member) {
                            $profileImage = $member->profile_img ? asset('storage/' . $member->profile_img) : asset('/storage/images/avatarlogo.jpg');
                            $html .= '<div class="w-12 h-12 m-2 overflow-hidden bg-gray-200 rounded-lg shadow-md">
                                        <img src="' . $profileImage . '" alt="profile image" class="object-cover w-full h-full">
                                    </div>';
                        }
                    }
                    $html .='</div>';
                    
                    return $html;
                }) 
                ->editColumn('start_date', function($each){
                    return Carbon::parse($each->updated_at)->format('d-m-Y ');
                })
                ->editColumn('deadline', function($each){
                    return Carbon::parse($each->updated_at)->format('d-m-Y ');
                })
                ->editColumn('status', function($each){
                    if($each->status === "Pending"){
                        return '<span class="text-danger">Pending</span>';
                    }else if($each->status === "In Progess"){
                        return '<span class="text-warning">In Progess</span>';
                    }else{
                        return '<span class="text-success">Complete</span>';
                    }
                })
                ->editColumn('priority', function($each){
                    if($each->priority === "Low"){
                        return '<span class="text-danger">Low</span>';
                    }else if($each->priority === "Middle"){
                        return '<span class="text-warning">Middle</span>';
                    }else{
                        return '<span class="text-success">High</span>';
                    }
                })
                ->addColumn('action', function($each) {
                    $editBtn = '';
                    $deleteBtn = '';
                    $user = auth()->user();
                    $userID = $user->id;
                    // Check if the user is a leader or a member
                    $isLeader = $each->leaders->contains('id', $userID);
                    $isMember = $each->members->contains('id', $userID);
                    $infoBtn="";
                    // Check if user has permission to edit Projects
                    if ($isLeader || $isMember)  {
                        $infoBtn = '<a href="/project/' . $each->id . '" class="info detail btn btn-sm"><i class="bi text-info bi-info-square"></i></a>';
                    }
                    if ($user->can('edit projects')) {
                        $editBtn = '<a href="/project/' . $each->id . '/edit" class="edit btn btn-sm"><i class="text-success bi bi-pencil-square"></i></a>';
                    }
                
                    // Check if user has permission to delete projects
                    if ($user->can('delete projects')) {
                        $deleteBtn = '<a href="#" data-id="'. $each->id .'" class="delete btn btn-sm"><i class="text-danger bi bi-trash"></i></a>';
                    }
                
                    return "<div class='flex items-center justify-between btnflex'>". $infoBtn . $editBtn . ' ' . $deleteBtn ."</div>";
                })
                ->addColumn('plus-icon', function($each){
                    return '<i class="bi bi-plus"></i>';
                })
                ->rawColumns(['action', 'plus-icon', 'images', 'status', 'priority', 'leaders', 'members'])
                ->make(true);
        }
        return view('project.index');
    }

    public function createView(){
        $users = User::all();
        return view('project.create', [
            'users' => $users
        ]);
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
            'leaders' => ['required', 'array'], 
            'members' => ['required', 'array'],
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
        
        $pid = $project->id;

        foreach ($formData['leaders'] as $uid) {
            $leaderData = [
                'user_id' => $uid,
                'project_id' => $pid,
            ];
    
            ProjectLeader::create($leaderData);
        }

        foreach ($formData['members'] as $uid) {
            $leaderData = [
                'user_id' => $uid,
                'project_id' => $pid,
            ];
    
            ProjectMember::create($leaderData);
        }
        

        return redirect('/project')->with('success', $project->title . ' Project created successfully');
    }    

    public function show($id){
        $project = Project::findOrFail($id);
        $users = User::all();
        $leaders = [];
        $members = [];
        
        return view('project.detail', [
            'users' => $users,
            'project' => $project,
            'leaders' => $leaders,
            'members' => $members,
        ]);
    }

    public function edit($id){
        $project = Project::findOrFail($id);
        $users = User::all();
        $leaders = [];
        $members = [];

        foreach ($project->leaders as $leader) {
            $leaders[] = $leader->id;
        }
        foreach ($project->members as $member) {
            $members[] = $member->id;
        }
        return view('project.edit', [
            'users' => $users,
            'project' => $project,
            'leaders' => $leaders,
            'members' => $members,
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
        $Project->leaders()->sync($request['leaders']);
        $Project->members()->sync($request['members']);    
        return redirect('/project')->with('success', $Project->title . 'Project updated: successfully');    
    }

    public function delete($id){
        $Project = Project::findOrFail($id);

        $project_leaders = ProjectLeader::where('project_id', $Project->id)->get();
        foreach($project_leaders as $project_leader){
            $project_leader->delete();
        }

        $project_members = ProjectMember::where('project_id', $Project->id)->get();
        foreach($project_members as $project_member){
            $project_member->delete();
        }

        $Project->delete();
        return redirect('/project');  
    }

}
