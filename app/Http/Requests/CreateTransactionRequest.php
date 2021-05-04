<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateTransactionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'payer_wallet_id' => 'exists:wallets,id',
            'payee_wallet_id' => 'exists:wallets,id',
            'description' => 'sometimes|string',
            'value' => 'required|gt:0',
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
            'payer_wallet_id.exists' => 'Please inform a valid wallet id',
            'payee_wallet_id.exists' => 'Please inform a valid wallet id',
            'description.string' => 'Description should be a string',
            'value.gt' => 'Invalid value informed!',
        ];
    }
}
