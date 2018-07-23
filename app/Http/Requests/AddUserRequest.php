<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddUserRequest extends FormRequest
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
        $this->sanitize();
        
        return [
            'username' => 'required',
            'firstname' => 'required'
            'lastname' => 'required'
        ];

    }

    public function sanitize()
    {
        $input = $this->all();

        $input['name'] = filter_var($input['name'], FILTER_SANITIZE_STRING);
        $input['content'] = filter_var($input['content'], 
        FILTER_SANITIZE_STRING);

        $this->replace($input);     
    }

}
