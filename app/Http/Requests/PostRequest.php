<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
            'title' => 'required',
            'content' => 'required',
            'date' => 'required',
            'description' => 'required',
            'image' => 'nullable|image',
        ];
    }
    public function messages()
    {
        return [
          'title.required' => "Заповни тайтл",  
          'content.required' => "Заповни контент",  
          'date.required' => "Заповни дату",  
          'description.required' => "Заповни опис",  
        ];
    }
}
