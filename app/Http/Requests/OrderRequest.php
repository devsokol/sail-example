<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Enums\OrderStatus;

class OrderRequest extends FormRequest
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
        if ($request->isMethod('post')) {
            return [
                'good_id' => ['required', 'integer', 'exists:goods,id'],
            ];
        } elseif ($request->isMethod('put')) {
            return [
                'status' => ['required', 'integer', Rule::in([
                    OrderStatus::InProgress,
                    OrderStatus::Done,
                    OrderStatus::Archive,
                ])],
            ];
        }

        return [];
    }
}
