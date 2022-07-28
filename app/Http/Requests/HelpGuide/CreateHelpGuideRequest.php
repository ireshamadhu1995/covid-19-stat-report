<?php

namespace App\Http\Requests\HelpGuide;

use Illuminate\Foundation\Http\FormRequest;

class CreateHelpGuideRequest extends FormRequest
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
            'topic' => 'required|string',
            'description' => 'required|string',
            'images' => 'array',
            'images.*' => 'image|mimes:jpg,jpeg,png|max:2560',
            'link' => 'required|url'
        ];
    }
}
