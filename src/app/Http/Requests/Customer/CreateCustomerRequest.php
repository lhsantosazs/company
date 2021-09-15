<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateCustomerRequest extends FormRequest
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
            'companyId' => 'numeric|exists:company,id',
            'login' => 'required|string',
            'name' => 'required|string',
            'cpf' => 'required|string',
            'email' => 'required|string',
            'adress' => 'required|string',
            'password' => 'required|string',
            'doc' => 'required'
        ];
    }

    /**
     * Return validation errors as json response
     *
     * @param Validator $validator
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = ['Validation errors' => $validator->errors()];

        throw new HttpResponseException(response()->json($errors, 400));
    }
}
