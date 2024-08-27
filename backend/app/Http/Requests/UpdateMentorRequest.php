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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
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
}
