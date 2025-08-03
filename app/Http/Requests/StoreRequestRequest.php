<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequestRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
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
    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'requested_at' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'user_id.required' => 'O campo usuário é obrigatório.',
            'user_id.exists' => 'O usuário selecionado não existe.',
            'requested_at.required' => 'A data da requisição é obrigatória.',
            'requested_at.date' => 'A data da requisição deve ser uma data válida.',
            'items.required' => 'É necessário adicionar pelo menos um item à requisição.',
            'items.array' => 'O formato dos itens é inválido.',
            'items.min' => 'É necessário adicionar pelo menos um item à requisição.',
            'items.*.product_id.required' => 'O produto é obrigatório para cada item.',
            'items.*.product_id.exists' => 'O produto selecionado não existe.',
            'items.*.quantity.required' => 'A quantidade é obrigatória para cada item.',
            'items.*.quantity.integer' => 'A quantidade deve ser um número inteiro.',
            'items.*.quantity.min' => 'A quantidade deve ser pelo menos 1.',
        ];
    }
}