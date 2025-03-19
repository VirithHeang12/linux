<?php

namespace App\Http\Requests;

use App\Enums\Gender;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rules\Enum;

class RegisterRequest extends FormRequest
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
            'student_id'    => ['required', 'string', 'max:30', 'unique:students'],
            'first_name'    => ['required', 'string', 'max:255'],
            'last_name'     => ['required', 'string', 'max:255'],
            'gender'        => [new Enum(Gender::class)],
            'date_of_birth' => ['required', 'date'],
            'address'       => ['nullable', 'string'],
            'email'         => ['required', 'string', 'email', 'max:255', 'unique:students'],
            'phone'         => ['required', 'string', 'regex:/^(\+?\d{1,3})? ?\d{8,15}$/'],
            'image'         => ['nullable', 'image', 'max:2048'],
            'password'      => ['required','string',Password::min(8)->numbers(),'confirmed'],

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
            'image.image'            => 'Image must be an image.',
            'image.max'              => 'Image must not be greater than :max kilobytes.',
            'password.required'      => 'Password is required.',
            'password.string'        => 'Password must be a string.',
            'password.min'           => 'Password must be at least :min characters.',
        ];
    }
}
