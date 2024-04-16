<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskMember;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TaskController extends Controller
{
    public function store(Request $request)
    {
        $formData = $request->validate([
            'project_id' => ['required', Rule::exists('projects', 'id')],
            'title' => ['required', 'max:255', 'min:5', Rule::unique('projects', 'title')],
            'description' => ['nullable', 'string'],
            'start_date' => ['nullable', 'date_format:Y/m/d'],
            'deadline' => ['nullable', 'date_format:Y/m/d', 'after_or_equal:start_date'],
            'priority' => ['required', 'string', Rule::in(['High', 'Middle', 'Low'])],
            'status' => ['required', 'string', Rule::in(['Pending', 'In Progress', 'Complete'])],
            'members' => ['required', 'array'],
        ]);
    
        // Create a new Task instance
        $task = new Task();
        $task->title = $formData['title'];
        $task->project_id = $formData['project_id'];
        $task->description = $formData['description'];
        $task->start_date = $formData['start_date'];
        $task->deadline = $formData['deadline'];
        $task->priority = $formData['priority'];
        $task->status = $formData['status'];
    
        // Save the Task to the database
        $task->save();
        
        $tid = $task->id;
        
        foreach ($formData['members'] as $uid) {
            $memberdata = [
                'user_id' => $uid,
                'task_id' => $tid,
            ];
    
            TaskMember::create($memberdata);
        }

        return response()->json(['message' => $task->title . ' Task created successfully'], 200);
    }    

    public function edit($id){
        $task = Task::findOrFail($id);
        $members = [];

        foreach ($task->members as $member) {
            $members[] = $member->id;
        }

        $task->members = $members;
        
        return response()->json($task);
    }

    public function update($id, Request $request){
        $task = Task::findOrFail($id); 
        $formData = $request->validate([
            'project_id' => ['required', Rule::exists('projects', 'id')],
            'title' => ['required', 'max:255', 'min:5', Rule::unique('projects', 'title')->ignore($task->id)],
            'description' => ['nullable', 'string'],
            'start_date' => ['nullable'],
            'deadline' => ['nullable', 'after_or_equal:start_date'],
            'priority' => ['required', 'string', Rule::in(['High', 'Middle', 'Low'])],
            'status' => ['required', 'string', Rule::in(['Pending', 'In Progress', 'Complete'])],
            'members' => ['required', 'array'],
        ]);
    
        $task->title = $formData['title'];
        $task->project_id = $formData['project_id'];
        $task->description = $formData['description'];
        $task->start_date = $formData['start_date'];
        $task->deadline = $formData['deadline'];
        $task->priority = $formData['priority'];
        $task->status = $formData['status'];
    
        // Save the Task to the database
        $task->update();
        
        $task->members()->sync($request['members']);    

        return response()->json(['message' => $task->title . ' Task updated successfully'], 200);
    }    

    public function updateStatus($id, Request $request){
        $task = Task::findOrFail($id); 
        $task->status = $request['status'];
    
        $task->update();

        return response()->json(['message' => $request['status'] . ' Status updated successfully'], 200);
    }    

    public function delete($id){
        $task = Task::findOrFail($id); 

        $task_members = TaskMember::where('task_id', $task->id)->get();
        foreach($task_members as $task_member){
            $task_member->delete();
        }

        $task->delete();
        return response()->json(['message' => $task->title . ' Task deleted successfully'], 200);
    }
}
