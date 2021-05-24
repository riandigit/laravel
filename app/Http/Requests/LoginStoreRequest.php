<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginStoreRequest extends FormRequest
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
            //
            'firstname' => 'string|max:100|nullable',
            'lastname' => 'string|max:100|nullable',
            'name' => 'string|max:100|nullable',
            'email' => 'required|string|email',
            'password' => 'required|string',
            'id_sso' => 'max:30|nullable|string',
            'position' => 'string|max:30|nullable',
            'user_type' => 'string|max:30|nullable',
            'picture' => 'string|nullable',
            'phone' => 'max:15|numeric|nullable',
            'birthday' => 'numeric|nullable',
            'gender' => 'integer|nullable'
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Email is required!',
            'password.required' => 'Password is required!'
        ];
    }
}
