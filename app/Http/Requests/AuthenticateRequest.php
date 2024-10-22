<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthenticateRequest extends FormRequest
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
            'login' => 'required|string',
            'password' => 'required|string',
        ];
    }

   /**
    * Custom messages for validation.
    *
    * @return array
    */
   public function messages()
   {
       return [
           'login.required' => 'O campo login é obrigatório.',
           'password.required' => 'O campo senha é obrigatório.',
           'password.min' => 'A senha deve ter no mínimo 6 caracteres.',
       ];
   }
}
