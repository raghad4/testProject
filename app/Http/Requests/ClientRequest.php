<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
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
            'username' => ['required','regex:/^[a-zA-Z0-9]*([a-zA-Z][0-9]|[0-9][a-zA-Z])[a-zA-Z0-9]*$/','min:8','unique:clients','regex:/^\S*$/u'],
            'email' => 'email|required|unique:clients',
            'name' => 'regex:/^[a-zA-Z ]+$/|required',
            'password' => 'regex:/(^([a-zA-Z0-9]+)(?=.*[A-Z]))/u|required',
            'biography' => 'required|min:10',
            'img'=>'image|mimes:jpeg,png,jpg,gif,svg'
        ];
    }

    public function messages()
    {
        return [
            'username.regex' => 'username must has numbers and letters',
            'name.regex' => 'name cannot contain numbers or symbols',
            'password.regex' =>'Password has to contain a combination of letters and numbers with at least one
            Capital letter',
        ];
    }
}
