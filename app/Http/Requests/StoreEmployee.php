<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployee extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'employee_id' => 'required|numeric',
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|numeric|max:11|min:10',
            'NRC Number' => 'required',
            'gender' => 'required|in:Male,Female',
            'birthday' => 'required|date',
            'department_id' => 'required|exists:departments,id',
            'address' => 'required|string',
            'date_of_join'=> 'required',
            'is_present' => 'required'
        ];
    }
}
