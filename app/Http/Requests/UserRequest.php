<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(Request $request): array
    {
        $rules = [
            'name' => ['string', 'max:255'],
            'email' => ['string', 'email', 'max:255', 'unique:users'],
            'password' => ['string', 'min:8'],
            'role_id' => ['integer', 'exists:roles,id'],
        ];

        if ($request->isMethod('post')) {
            foreach ($rules as $field => $rule) {
                array_unshift($rule, 'required');
                $rules[$field] = $rule;
            }
        } elseif ($request->isMethod('put')) {
            foreach ($rules as $field => $rule) {
                array_unshift($rule, 'sometimes');
                $rules[$field] = $rule;
            }
            $rules['email'][] = Rule::unique('users')->ignore($request->user()->id);
        }

        return $rules;
    }
}
