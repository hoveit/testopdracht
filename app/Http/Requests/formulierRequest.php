<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class formulierRequest extends FormRequest
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
            "aanhef" => "required|string|max:100",
            "voornaam" => "required|string|max:100",
            "tussenvoegsel" => "required|string|max:100",
            "achternaam" => "required|string|max:100",
            "email" => "required|string|email|max:100|unique:forms",
            "land" => "required|string|max:10" 
        ];
    }
}
