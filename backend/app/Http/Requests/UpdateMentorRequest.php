<?php

namespace App\Http\Requests;

use App\Models\RoleEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateMentorRequest extends FormRequest
{

    public function authorize(): bool
    {
        $isAdminMentor = Auth::user()->role === RoleEnum::ADMIN->value;
        $isOwnAccountMentor = Auth::user()->id === $this->route()->mentor->id;

        return $isAdminMentor || $isOwnAccountMentor;
    }

    public function rules(): array
    {
        $mentorId = (string) $this->route()->mentor->id;

        return [
            'name' => 'required|string|max:255',
            'email' => [
                'string',
                'required',
                'email',
                'max:255',
                Rule::unique('mentors', 'email')->ignore($mentorId),
            ],
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
        ];
    }
}
