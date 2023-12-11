<?php

namespace App\Http\Requests\Roles;

use Illuminate\Foundation\Http\FormRequest;

class CreateRoleRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [ // bắt buộc phải điền các giá trị vào biểu mẫu khi bấm Submit
            'name' => 'required',
            'display_name' => 'required',
            'group' => 'required'
        ];
    }
}
