<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DepositRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0.01',
        ];
    }

    public function messages()
    {
        return [
            'user_id.required' => 'ID пользователя обязателен.',
            'user_id.exists' => 'Пользователь с таким ID не найден.',
            'amount.required' => 'Сумма обязательна.',
            'amount.numeric' => 'Сумма должна быть числом.',
            'amount.min' => 'Сумма должна быть не менее 0.01.',
        ];
    }
}
