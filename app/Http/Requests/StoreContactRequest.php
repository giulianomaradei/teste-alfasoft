<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:6|max:255',
            'email' => 'required|email|unique:contacts,email',
            'contact' => 'required|digits:9|unique:contacts,contact',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'O nome é obrigatório.',
            'name.min' => 'O nome deve ter pelo menos 6 caracteres.',
            'email.required' => 'O email é obrigatório.',
            'email.email' => 'Por favor, insira um email válido.',
            'email.unique' => 'Este email já está sendo usado por outro contato.',
            'contact.required' => 'O contato é obrigatório.',
            'contact.digits' => 'O contato deve ter exatamente 9 dígitos.',
            'contact.unique' => 'Este contato já está sendo usado por outro contato.',
        ];
    }
}