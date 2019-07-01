<?php

namespace App\Http\Requests\Admin\Pages\Sections;

use App\Http\Requests\Request;

use App\Models\Pages\Sections\Type;

class CreatePageSectionRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->user && $this->user->hasPermission('manage_pages') ) {
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
        $types = Type::get();
        $limited_types = $types
            ->where("protected", false)
            ->where("unlimited", false)
            ;
        $editable_types = $types
            ->where("protected", false)
            ;
        return [
            'index'                 => 'required|max:255|alpha_dash|unique:sections,index',
            'template_path'         => 'required|max:255',
            'type_id'               => 'exists:sectiontypes,id',
            'components_max'        => 'integer|min:1|required_if:type_id,'.$limited_types->implode("id",","),
            "editable_contents"     => 'array|required_if:type_id,'.$editable_types->implode("id",","),
            "editable_contents.*"   => 'boolean',
            "description"           => "required|string"
        ];
    }
}
