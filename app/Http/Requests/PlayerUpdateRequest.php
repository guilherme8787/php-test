<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlayerUpdateRequest extends FormRequest
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
    public function rules()
    {
        return [
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:5',
            'height' => 'nullable|string|max:10',
            'weight' => 'nullable|integer|min:0',
            'jersey_number' => 'nullable|string|max:10',
            'college' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'draft_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'draft_round' => 'nullable|integer|min:1|max:10',
            'draft_number' => 'nullable|integer|min:1',
            'team_id' => 'nullable|exists:teams,id',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'first_name.string' => 'O primeiro nome deve ser uma string.',
            'first_name.max' => 'O primeiro nome não pode ter mais de 255 caracteres.',

            'last_name.string' => 'O sobrenome deve ser uma string.',
            'last_name.max' => 'O sobrenome não pode ter mais de 255 caracteres.',

            'position.string' => 'A posição deve ser uma string.',
            'position.max' => 'A posição não pode ter mais de 5 caracteres.',

            'height.string' => 'A altura deve ser uma string.',
            'height.max' => 'A altura não pode ter mais de 10 caracteres.',

            'weight.integer' => 'O peso deve ser um número inteiro.',
            'weight.min' => 'O peso deve ser maior ou igual a 0.',

            'jersey_number.string' => 'O número da camisa deve ser uma string.',
            'jersey_number.max' => 'O número da camisa não pode ter mais de 10 caracteres.',

            'college.string' => 'A faculdade deve ser uma string.',
            'college.max' => 'A faculdade não pode ter mais de 255 caracteres.',

            'country.string' => 'O país deve ser uma string.',
            'country.max' => 'O país não pode ter mais de 255 caracteres.',

            'draft_year.integer' => 'O ano do draft deve ser um número inteiro.',
            'draft_year.min' => 'O ano do draft deve ser maior ou igual a 1900.',
            'draft_year.max' => 'O ano do draft não pode ser maior que o ano atual.',

            'draft_round.integer' => 'A rodada do draft deve ser um número inteiro.',
            'draft_round.min' => 'A rodada do draft deve ser maior ou igual a 1.',
            'draft_round.max' => 'A rodada do draft não pode ser maior que 10.',

            'draft_number.integer' => 'O número do draft deve ser um número inteiro.',
            'draft_number.min' => 'O número do draft deve ser maior ou igual a 1.',

            'team_id.exists' => 'O time selecionado não é válido.',
        ];
    }
}
