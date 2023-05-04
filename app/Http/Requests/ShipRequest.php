<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShipRequest extends FormRequest
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
        return [
            "ship_code" => "required|string|max:16",
            "ship_name" => "required|string|max:16",
            "ship_owner" => "required|string|max:16",
            "address_owner" => "required|string|max:16",
            "ship_size" => "required|string|max:16",
            "captain" => "required|string|max:16",
            "member" => "required|string|max:16",
            "permit_number" => "required|string|max:16",
            "permit_document" => "required|string|max:16",
            "created_by" => "required|integer|max:16"
        ];
    }

    public function messages()
    {
        return [
            'ship_code.required' => 'Ship Code is required!'
        ];
    }
}
