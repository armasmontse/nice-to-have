<?php

namespace App\Http\Requests\Admin\Photos;

use App\Http\Requests\Request;

use App\Photo;

class DisassociatePhotoRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->user && $this->user->hasPermission('associate_photos') ) {
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
        $input = $this->all();
        $rules = [
            "photoable_type"    => "required|in:".Photo::getImpodeCodesToAssociateModels(),
            "photoable_id"      => "required",
            "use"               => "required",
            "order"             => "present",
            "class"             => "present"
        ];

        if ( isset($input["order"]) && $input["order"] == "null") {
            $input["order"] .= "integer|min:0";
        }

        if (isset($input["photoable_type"])  ) {

            $table_name = Photo::getTableOfAssociateModelForCode($input["photoable_type"]);

            if ($table_name) {
                if ($input["photoable_type"] == "sku") {
                    $rules["photoable_id"] .= "|exists:" . $table_name. ",sku" ;
                }elseif ($input["photoable_type"] == "setting") {
                    $rules["photoable_id"] .= "|exists:".$table_name.",key" ;
                }else {
                    $rules["photoable_id"] .= "|exists:".$table_name.",id" ;
                }
            }
        }

        return $rules;
    }
}
