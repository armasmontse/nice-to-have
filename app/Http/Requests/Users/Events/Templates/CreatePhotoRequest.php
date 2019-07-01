<?php

namespace App\Http\Requests\Users\Events\Templates;

use App\Http\Requests\Request;

use App\Photo;

class CreatePhotoRequest extends Request
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
        $input = $this->all();

        $rules = [
            "photoable_type"    => "required|in:template,section",
            "photoable_id"      => "required",
            "image"             => "required|image|max:2048"
        ];

        if (isset($input["photoable_type"])  ) {

            $table_name = Photo::getTableOfAssociateModelForCode($input["photoable_type"]);

            if ($table_name) {
                if ($input["photoable_type"] == "template") {
                    $rules["photoable_id"] .= "|exists:".$table_name.",event_id" ;
                }else {
                    $rules["photoable_id"] .= "|exists:".$table_name.",id" ;
                }
            }
        }

        return $rules;
    }
}
