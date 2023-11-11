<?php

namespace App\Http\Requests\Profile;


use App\Http\Requests\Api\FormRequest;

class EditUserProfileFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'image' => ['required', 'mimes:jpeg,jpg,png,gif', 'max:5120']
        ];
    }
}
