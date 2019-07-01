<?php

namespace App\Http\Requests\Admin\Photos;

use App\Http\Requests\Request;

class UpdatePhotoRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->user && $this->user->hasPermission('manage_photos') ) {
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
            'title'         => 'required',
            'alt'           => 'required',
            'description'   => 'required'
        ];

        foreach ($this->languages_isos as $language_iso) {
            $rules['title.'. $language_iso] = "present";
            $rules['alt.'. $language_iso] = "required";
            $rules['description.'. $language_iso] = "present";
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'title.*'          => trans('manage_photos.title_present'),
            'alt.*'            => trans('manage_photos.alt_required'),
            'description.*'    => trans('manage_photos.description_present')
        ];
    }
}
