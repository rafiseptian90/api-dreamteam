<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
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
        if($this->isMethod("POST")){
            return [
                'name' => 'required|regex:/^[a-zA-Z ]+$/',
                'email' => 'required|email',
                'username' => 'required|string|min:1|max:12|regex:/^[a-zA-Z0-9_]+$/',
                'password' => 'required'
            ];
        } else {
            return [
                'name' => 'required|regex:/^[a-zA-Z ]+$/',
                'email' => 'required|email',
                'username' => 'required|string|min:1|max:12|regex:/^[a-zA-Z0-9_]+$/'
            ];
        }
    }
}
