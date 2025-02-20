<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username,' . $this->route('user')],
            'email' => ['required', 'email', 'unique:users,email,' . $this->route('user')],
            'password' => ['nullable', 'required_with:password_confirmation', 'min:8'],
            'password_confirmation' => ['nullable', 'required_with:password', 'same:password'],
            'joining_date' => ['required', 'date'],
            'positions' => ['required', 'array'],
        ];

        if (is_integer(request('unit'))) {
            $rules['unit'] = ['exists:units,id'];
        } else {
            $rules['unit'] = ['required', 'string', 'max:255'];
        }

        foreach (request('positions') as $key => $value) {
            if (is_integer(request('positions.' . $key))) {
                $rules['positions.' . $key] = ['exists:positions,id'];
            }
        }

        return $rules;
    }
}
