<?php

namespace App\Http\Requests\admin\Investor;

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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'required|exists:users,id',
            'name' => 'required|max:255|string',
            'email' => ['required', 'max:244', 'email', Rule::unique('users')->ignore($this->id)],
            'password' => 'required|max:255',
            'phone' => 'required|max:255',
            'UserImage' => 'nullable|image',
            'UserCardImage' => 'nullable|image',
            'PassPortImage' => 'nullable|image',
            'PassPortNo' => 'required|max:255',
            'sponsorName' => 'required|string|max:255',
            'sponsorCardImage' => 'nullable|image',
            'sponsorPhone' => 'required|max:255',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();

        throw new HttpResponseException(
            response()->json(['error', $errors], JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
        );
    }
}
