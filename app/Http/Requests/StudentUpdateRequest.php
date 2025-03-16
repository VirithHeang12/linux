<?php

namespace App\Http\Requests;

use App\Enums\Gender;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class StudentUpdateRequest extends FormRequest
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
            'student_id' => [
                'required',
                'string',
                'max:30',
                Rule::unique('students', 'student_id')->ignore($this->route('student'))
            ],
            'first_name'    => ['required', 'string', 'max:255'],
            'last_name'     => ['required', 'string', 'max:255'],
            'gender'        => [new Enum(Gender::class)],
            'date_of_birth' => ['required', 'date'],
            'address'       => ['nullable', 'string'],
            'email'         => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('students', 'email')->ignore($this->route('student'))
            ],
            'phone'         => ['required', 'string', 'regex:/^(\+?\d{1,3})? ?\d{8,15}$/'],
            'academics'     => ['array'],
            'academics.*.academic_id' => ['required', 'exists:academics,id'],
            'academics.*.room_no'     => ['required', 'string'],
            'academics.*.class'       => ['required', 'string'],
            'image'         => ['nullable', 'image', 'max:2048']
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
            'student_id.required'    => 'Student ID is required.',
            'student_id.string'      => 'Student ID must be a string.',
            'student_id.max'         => 'Student ID must not be greater than :max characters.',
            'student_id.unique'      => 'Student ID has already been taken.',
            'first_name.required'    => 'First name is required.',
            'first_name.string'      => 'First name must be a string.',
            'first_name.max'         => 'First name must not be greater than :max characters.',
            'last_name.required'     => 'Last name is required.',
            'last_name.string'       => 'Last name must be a string.',
            'last_name.max'          => 'Last name must not be greater than :max characters.',
            'gender.enum'            => 'Invalid gender.',
            'date_of_birth.required' => 'Date of birth is required.',
            'date_of_birth.date'     => 'Date of birth must be a date.',
            'address.string'         => 'Address must be a string.',
            'email.required'         => 'Email is required.',
            'email.string'           => 'Email must be a string.',
            'email.email'            => 'Email must be a valid email address.',
            'email.max'              => 'Email must not be greater than :max characters.',
            'email.unique'           => 'Email has already been taken.',
            'phone.required'         => 'Phone number is required.',
            'phone.string'           => 'Phone number must be a string.',
            'phone.regex'            => 'Invalid phone number.',
            'academics.array'        => 'Academics must be an array.',
            'academics.*.academic_id.required' => 'Academic ID is required.',
            'academics.*.academic_id.exists'   => 'Academic ID does not exist.',
            'academics.*.room_no.required'     => 'Room number is required.',
            'academics.*.room_no.string'       => 'Room number must be a string.',
            'academics.*.class.required'       => 'Class name is required.',
            'academics.*.class.string'         => 'Class name must be a string.',
            'image.image'            => 'Image must be an image.',
            'image.max'              => 'Image must not be greater than :max kilobytes.'
        ];
    }
}
