<?php

namespace App\Http\Requests\admin\Deposit;

use Illuminate\Foundation\Http\FormRequest;

class AcceptInvestorRequest extends FormRequest
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
            'note' => 'nullable|max:255|string',
            'DateDelivery' => 'required|date',
        ];
    }
}
