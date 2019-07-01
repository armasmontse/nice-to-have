<?php

namespace App\Http\Requests\Users\Events\Templates;

use App\Http\Requests\Request;

class UpdateTemplateHeaderRequest extends Request
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
        $rules = [
            'html'                      => 'required|string|no_scripts',
            'background_color'          => 'required|string|no_scripts',
            'image_background_color'    => 'required|string|no_scripts'
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'html.required'                     => trans('events.validations.html.required'),
            'html.string'                       => trans('events.validations.html.string'),

            'background_color.required'         => trans('events.validations.background_color.required'),
            'background_color.string'           => trans('events.validations.background_color.string'),

            'image_background_color.required'   => trans('events.validations.image_background_color.required'),
            'image_background_color.string'     => trans('events.validations.image_background_color.string')
        ];
    }
}
 