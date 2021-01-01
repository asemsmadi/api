<?php

namespace App\Http\Requests\admin\transfers;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class create extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'amount' => 'required|numeric',
            'note' => 'nullable|max:255',
            'status' => 'required|in:1,2,3,4,5,6',
            'investor_id_From' => 'required|exists:investors,id',
            'investor_id_To' => 'required|exists:investors,id',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException(
            response()->json(['error', $errors], JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
        );
    }
}
