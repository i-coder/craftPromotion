<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
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
            'sortBy' => 'nullable|in:amount,created_at',
            'sortDirection' => 'nullable|in:asc,desc',
            'dateFrom' => 'nullable|date|before_or_equal:dateTo',
            'dateTo' => 'nullable|date|after_or_equal:dateFrom',
            'perPage' => 'nullable|integer|min:1|max:100',
        ];
    }

    public function messages()
    {
        return [
            'sortBy.in' => 'Сортировка может быть выполнена только по "amount" или "created_at".',
            'sortDirection.in' => 'Направление сортировки может быть только "asc" или "desc".',
            'dateFrom.date' => 'Поле "dateFrom" должно быть корректной датой.',
            'dateTo.date' => 'Поле "dateTo" должно быть корректной датой.',
            'perPage.integer' => 'Поле "perPage" должно быть числом.',
            'perPage.min' => 'Минимальное значение для "perPage" — 1.',
            'perPage.max' => 'Максимальное значение для "perPage" — 100.',
        ];
    }
}
