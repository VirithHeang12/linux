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
            'student_id'    => ['required', 'string', 'max:255', 'unique:students'],
            'first_name'    => ['required', 'string', 'max:255'],
            'last_name'     => ['required', 'string', 'max:255'],
            'gender'        => [new Enum(Gender::class)],
            'date_of_birth' => ['required', 'date'],
            'address'       => ['required', 'string', 'max:255'],
            'email'         => ['required', 'string', 'email', 'max:255', 'unique:students'],
            'phone'         => ['required', 'string', 'regex:/^(\+?\d{1,3})? ?\d{8,15}$/']
        ];
    }
}
