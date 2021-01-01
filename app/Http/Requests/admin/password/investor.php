<?php

namespace App\Http\Requests\admin\password;

use Illuminate\Foundation\Http\FormRequest;

class investor extends FormRequest
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
            'investor_id' => 'required|exists:investors,id',
            'password' => 'required|confirmed|min:6|max:100',
        ];
    }
}
