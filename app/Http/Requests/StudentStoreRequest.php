<?php

namespace App\Http\Requests;

use App\Enums\Gender;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StudentStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // 'student_id'    => ['required', 'string', 'max:255', 'unique:students'],
            'first_name'    => ['required', 'string', 'max:255'],
            'last_name'     => ['required', 'string', 'max:255'],
            // 'gender'        => [new Enum(Gender::class)],
            // 'date_of_birth' => ['required', 'date'],
            // 'address'       => ['required', 'string', 'max:255'],
            // 'email'         => ['required', 'string', 'email', 'max:255', 'unique:students'],
            // 'phone'         => ['required', 'string', 'regex:/^(\+?\d{1,3})? ?\d{8,15}$/']
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            // 'student_id.required'    => 'Student ID is required.',
            // 'student_id.string'      => 'Student ID must be a string.',
            // 'student_id.max'         => 'Student ID must not be greater than 255 characters.',
            // 'student_id.unique'      => 'Student ID must be unique. AH bek',
            'first_name.required'    => 'First name is required.',
            'first_name.string'      => 'First name must be a string.',
            'first_name.max'         => 'First name must not be greater than 255 characters.',
            'last_name.required'     => 'Last name is required.',
            'last_name.string'       => 'Last name must be a string.',
            'last_name.max'          => 'Last name must not be greater than 255 characters.',
        ];
    }
}
