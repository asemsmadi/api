<?php

namespace App\Http\Requests\admin\withdrawals;

use Illuminate\Foundation\Http\FormRequest;

class acceptRequest extends FormRequest
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
            'dateReceived' => 'required|date',
            'note' => 'required|string|max:255',
        ];
    }
}
