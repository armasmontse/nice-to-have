<?php

namespace App\Http\Requests\Admin\Photos;

use App\Http\Requests\Request;

class CreatePhotoRequest extends Request
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
        return [
            "file_input"    => "required|image|max:2048"
        ];
    }

    public function messages()
    {
        return [

            'file_input.*' =>  'El peso de la imagen debe ser menor o igual a 2 MB',
        ];
    }
}
 