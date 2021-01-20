<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PdfStoreRequest extends FormRequest
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
            'html' => 'required_without:url',
            'head' => 'nullable',
            'url'=>'required_without:html'
        ];
    }
}
