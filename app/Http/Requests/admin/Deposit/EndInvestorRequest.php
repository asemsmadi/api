<?php

namespace App\Http\Requests\admin\Deposit;

use Illuminate\Foundation\Http\FormRequest;

class EndInvestorRequest extends FormRequest
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
            'note' => 'required|max:255|string',
            'DateRun'=>'required|date',
        ];
    }
}
