<?php

namespace App\Http\Requests;

use App\Enums\Gender;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class ProfileUpdateRequest extends FormRequest
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
        $student = Auth::user()->userable;

        if (! $student) {
            throw new \Exception('Student not found');
        }

        return [
            'student_id' => [
                'required',
                'string',
                'max:30',
                Rule::unique('students', 'student_id')->ignore($student->id)
            ],
            'first_name'                => ['required', 'string', 'max:255'],
            'last_name'                 => ['required', 'string', 'max:255'],
            'gender'                    => [new Enum(Gender::class)],
            'date_of_birth'             => ['required', 'date'],
            'address'                   => ['nullable', 'string'],
            'phone'                     => ['required', 'string', 'regex:/^(\+?\d{1,3})? ?\d{8,15}$/'],
            'academics'                 => ['array'],
            'academics.*.academic_id'   => ['required', 'exists:academics,id'],
            'academics.*.room_no'       => ['required', 'string'],
            'academics.*.class'         => ['required', 'string'],
            'image'                     => ['nullable', 'image', 'max:2048'],
            'current_password'          => [
                'nullable',
                'string',
                'min:8',
                'max:255'
            ],
            'password'                  => [
                'nullable',
                'string',
                'min:8',
                'max:255',
                'confirmed'
            ],
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
            'student_id.required'               => 'Student ID is required.',
            'student_id.string'                 => 'Student ID must be a string.',
            'student_id.max'                    => 'Student ID must not be greater than :max characters.',
            'student_id.unique'                 => 'Student ID has already been taken.',
            'first_name.required'               => 'First name is required.',
            'first_name.string'                 => 'First name must be a string.',
            'first_name.max'                    => 'First name must not be greater than :max characters.',
            'last_name.required'                => 'Last name is required.',
            'last_name.string'                  => 'Last name must be a string.',
            'last_name.max'                     => 'Last name must not be greater than :max characters.',
            'gender.enum'                       => 'Invalid gender.',
            'date_of_birth.required'            => 'Date of birth is required.',
            'date_of_birth.date'                => 'Date of birth must be a date.',
            'address.string'                    => 'Address must be a string.',
            'phone.required'                    => 'Phone number is required.',
            'phone.string'                      => 'Phone number must be a string.',
            'phone.regex'                       => 'Invalid phone number.',
            'image.image'                       => 'Image must be an image.',
            'image.max'                         => 'Image must not be greater than :max kilobytes.',
            'current_password.string'           => 'Current password must be a string.',
            'current_password.min'              => 'Current password must be at least :min characters.',
            'current_password.max'              => 'Current password must not be greater than :max characters.',
            'password.string'                   => 'Password must be a string.',
            'password.min'                      => 'Password must be at least :min characters.',
            'password.max'                      => 'Password must not be greater than :max characters.',
            'password.confirmed'               => 'Password confirmation does not match.',
            'password_confirmation.string'      => 'Password confirmation must be a string.',
            'password_confirmation.min'         => 'Password confirmation must be at least :min characters.',
            'password_confirmation.max'         => 'Password confirmation must not be greater than :max characters.',
            'password_confirmation.same'        => 'Password confirmation must match the password.',
        ];
    }
}
