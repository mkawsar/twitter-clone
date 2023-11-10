<?php

namespace App\Http\Requests\Authentication;

use App\Http\Requests\Api\FormRequest;
use Illuminate\Contracts\Validation\Factory as ValidationFactory;

class LoginFormRequest extends FormRequest
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
            'username' => ['required'],
            'password' => ['required', 'min:6']
        ];
    }
}
