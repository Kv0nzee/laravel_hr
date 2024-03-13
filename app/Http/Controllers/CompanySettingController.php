<?php

namespace App\Http\Controllers;

use App\Models\CompanySetting;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CompanySettingController extends Controller
{
    public function index()
    {
            
        $data = CompanySetting::latest()->first();
        return view('companySetting.index', [
            'companySetting'=>$data
        ]);
    }

    public function edit($id){
        $companySetting = CompanySetting::findOrFail($id);
        return view('companySetting.edit', [
            'companySetting' => $companySetting
        ]);
    }    

    public function update(Request $request, $id){
        $companySetting = CompanySetting::findOrFail($id);
        $formData = $request->validate([
            'company_name' => ['required', 'max:255'],
            'email' => ['required', 'email', Rule::unique('company_settings', 'email')->ignore($companySetting->id)],
            'company_phone' => ['nullable', 'unique:company_settings,company_phone,'.$companySetting->id],
            'company_address' => ['required'],
            'office_start_time' => ['required'],
            'office_end_time' => ['required', 'after:office_start_time'],
            'break_start_time' => ['required', 'before:office_end_time'],
            'break_end_time' => ['required', 'after:break_start_time', 'before:office_end_time'],
        ]);
    
        $companySetting->update($formData);
    
        return redirect('/')->with('success', 'Company setting updated successfully');
    }
    
}
