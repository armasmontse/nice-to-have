<?php

namespace App\Http\Requests\Users\Events\Templates\Sections;

use App\Http\Requests\Request;
use App\Models\Events\EventTemplateSection;

class UpdateSectionEventRequest extends Request
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
        $template_section = $this->route()->parameters()['template_section'];

        $template_section->load('eventTemplateSectionType');

        $rules = [
            'background_color'  => 'required|string|no_scripts',
        ];

        if ($template_section->eventTemplateSectionType->rules['title']) {
            $rules['title'] = 'required|string|no_scripts';
        }

        if ($template_section->eventTemplateSectionType->rules['link']) {
            if ($template_section->eventTemplateSectionType->slug == 'video') {
                $rules['link'] = 'required|string|youtube_video_url';
            }
            if ($template_section->eventTemplateSectionType->slug == 'mapa') {
                $rules['link'] = 'required|string|google_maps_url';
            }
        }

        if ($template_section->eventTemplateSectionType->rules['html']) {
            $rules['html'] = 'required|string|no_scripts';
        }

        if ($template_section->eventTemplateSectionType->rules['iframe']) {
            $rules['iframe'] = 'required|string|no_scripts';
        }

        return $rules;

    }

    public function messages()
    {
        return [
            'link.google_maps_url' => 'El link ingresado no es un link de google valido.',
            'link.youtube_video_url' => 'El link ingresado no es un link de youtube valido.',
            'html.required'                     => trans('events.text.html.required'),
            'html.string'                       => trans('events.text.html.string'),
        ];
    }
}
