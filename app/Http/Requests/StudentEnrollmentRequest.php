<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentEnrollmentRequest extends FormRequest
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
            'student_ids'       => 'required|array',
            'student_ids.*'     => 'exists:students,id',
        ];
    }

    /**
     * Get message bag for the validation rules.
     *
     * @return array<string, string>
     *
     */
    public function messages(): array
    {
        return [
            'student_ids.required' => 'The student ids field is required.',
            'student_ids.array'    => 'The student ids field must be an array.',
            'student_ids.*.exists' => 'The selected student id is invalid.',
        ];
    }
}
