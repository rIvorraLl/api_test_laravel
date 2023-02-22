<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * Returns true, auth is done elsewhere
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'string|max:150',
            'excerpt' => 'string|max:200',
            'content' => 'string|max:255',
            'expirable' => 'boolean',
            'mentionable' => 'string',
            'isPublic' => 'string',
        ];
    }
}
