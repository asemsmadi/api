<?php

namespace App\Http\Requests\admin\admin;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class update extends FormRequest
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

    public function rules()
    {
        return [
            'id' => 'required|exists:users,id',
            'name' => 'required|max:255|string',
            'email' => ['required', 'max:244', 'email', Rule::unique('users')->ignore($this->id)],
            'type' => 'required|in:1,2'
        ];
    }

}
