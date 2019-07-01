<?php

namespace App\Http\Requests\Admin\Photos;

use App\Http\Requests\Request;

use App\Photo;

class SortPhotoRequest extends Request
{

    public function __construct(\Illuminate\Http\Request $request)
    {
        $input = $request->request->all();
        $request->request->add(['photos_associated' => isset($input["photos"]) ?$input["photos"] : []  ]);
        parent::__construct($request);
    }
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
        $photoable_id   = isset($input["photoable_id"]) ? $input["photoable_id"] : "0" ;
        $photoable_type = isset($input["photoable_type"]) ? $input["photoable_type"] : "0";
        $use = isset($input["use"]) ? $input["use"] : "0";

        $rules = [
            "photoable_type"        => "required|in:".Photo::getImpodeCodesToAssociateModels(),
            "photoable_id"          => "required",
            "photos"                => "required|array",
            "photos.*"              => "required|exists:photos,id",
            "use"                   => "required",
            "class"                 => "present"
        ];

        if ( in_array($photoable_type, Photo::$associable_models) ) {

            $table_name = Photo::getTableOfAssociateModelForCode($input["photoable_type"]);

            if ($table_name) {
                $rules["photoable_id"] .= "|exists:".$table_name.",id";
            }

            $rules["photos_associated.*"] =  "exists:photoables,photo_id,photoable_id,".$photoable_id.",photoable_type,".Photo::$associable_models[$photoable_type].",use,".$use;

            $photoable_class = Photo::$associable_models[$photoable_type];
            $rules['use'] .= '|in:' . implode(',', $photoable_class::$image_galleries);
        }
        return $rules;
    }
}
