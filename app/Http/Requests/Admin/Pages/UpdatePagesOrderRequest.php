<?php

namespace App\Http\Requests\Admin\Pages;

use App\Http\Requests\Request;

class UpdatePagesOrderRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->user && ($this->user->hasPermission('manage_pages_contents') ) ) {
            return true;
        }

        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            "pages"     => 'required|array',
            "pages.*"   => 'required|exists:pages,id',
        ];
        return $rules;
    }

    public function messages()
    {
        return [
            'pages.required'    => 'Las páginas son obligatorias.',
            'pages.*.required'  => 'Las páginas es obligatorio.',
            'pages.*.exist'     => 'Las página no existe.',
        ];
    }
}
