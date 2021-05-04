<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Traits\SanitizesInput;

class CreateUserRequest extends FormRequest
{
    use SanitizesInput;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function filters()
    {
        return [
            'before' => [
                'cpf' => 'digit|trim',
                'email' => 'trim',
                'name' => 'trim',
                'type' => 'uppercase|trim',
            ]
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'string',
            'email' => 'unique:users|required|email',
            'cpf' => 'integer|unique:users|required|cpf_cnpj',
            'type' => 'in:COMMON,SHOPKEEPER',
            'password' => 'required',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'cpf.cpf_cnpj' => 'The cpf/cnpj must be valid',
        ];
    }
}
