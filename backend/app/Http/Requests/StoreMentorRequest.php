<?php

namespace App\Http\Requests;

use App\Models\RoleEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreMentorRequest extends FormRequest
{

    public function authorize(): bool
    {
        $isAdminMentor = Auth::user()->role === RoleEnum::ADMIN->value;
        return $isAdminMentor;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:mentors',
            'password' => 'required|string|min:5',
            'role' => [Rule::enum(RoleEnum::class)],
            'cpf' => 'required|string|size:14|unique:mentors',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a string.',
            'name.max' => 'The name may not be greater than 255 characters.',

            'email.required' => 'The email field is required.',
            'email.string' => 'The email must be a string.',
            'email.email' => 'The email must be a valid email address.',
            'email.max' => 'The email may not be greater than 255 characters.',
            'email.unique' => 'The email has already been taken.',

            'password.required' => 'The password field is required.',
            'password.string' => 'The password must be a string.',
            'password.min' => 'The password must be at least 8 characters.',

            'role.enum' => 'The selected role is invalid. Please choose either "ADMIN" or "VIEWER".',

            'cpf.required' => 'The CPF field is required.',
            'cpf.string' => 'The CPF must be a string.',
            'cpf.size' => 'The CPF must be exactly 11 characters.',
            'cpf.unique' => 'The CPF has already been taken.',
        ];
    }
}
