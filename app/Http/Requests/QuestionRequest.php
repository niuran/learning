<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class QuestionRequest extends FormRequest
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
    {//type', 'title', 'content', 'answer', 'sort
        return [
            'type' => 'required|Rule::in(["text", "radio", "checkbox", "textarea"])',
            'title' => 'required|max:120',
            'content' => 'max:1000',
            'sort' => 'integer',
        ];
    }

}
