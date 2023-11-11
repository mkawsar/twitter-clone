<?php

namespace App\Http\Requests\Tweet;


use App\Http\Requests\Api\FormRequest;

class CreateTweetFormRequest extends FormRequest
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
            'tweet' => ['required', 'string', 'min:10', 'max:200']
        ];
    }
}
