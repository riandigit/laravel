<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MemberUpdateRequest extends FormRequest
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
            'firstname' => 'required|string|max:100',
            'lastname' => 'string|max:100|nullable',
            'name' => 'string|max:100|nullable',
            'position' => 'string|max:30|nullable',
            'picture' => 'string|nullable',
            'phone' => 'max:15|numeric|nullable',
            'birthday' => 'numeric|nullable',
            'gender' => 'integer|nullable',
        ];
    }
    public function messages()
    {
        return [
            'email.required' => 'Email is required!',
            'email.unique' => 'Email is already register!',
            'firstname.required' => 'Firstname is required!'
        ];
    }
}
