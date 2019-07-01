<div id="{{ $template_name }}" class="grid__row event__row event__template-{{ $template_name }}" style="margin-bottom: 30px;">

    @include('client.general.scroll-up-icon')

    @include('client.events.templates.'.$template_name.'.header', [
        'image_url'                 => ( isset($event->thumbnail_image->url ) ? $event->thumbnail_image->url : null),
        'background_color'          => "#".$template->background_color,
        'image_background_color'    => "#".$template->image_background_color,

        "timer_show"                => $template->timer,
        "link_mesa_regalos"         => $event->shop_url,
        "name"                      => $event->name,

        "date"                      => $event->date,
        "description"               => $event->description,

        "form_route"                => "pendiente",
        "sections"                  => $sections
    ])

    @foreach ($sections as $section)

        @include('client.events.templates.'.$template_name.'.section', [
            "background_color"          => "#".$section->background_color,
            "full_with"                 => $section->eventTemplateSectionType->rules["iframe"] ?  "--full-width" : "",
            "rules"                     => [
                                            "title"     =>$section->eventTemplateSectionType->rules["title"],
                                            "link"      =>$section->eventTemplateSectionType->rules["link"],
                                            "html"      =>$section->eventTemplateSectionType->rules["html"],
                                            "photo"     =>$section->eventTemplateSectionType->rules["photo"],
                                            "iframe"    =>$section->eventTemplateSectionType->rules["iframe"],
                                        ],
            "title"                     => $section->title,
            "link"                      => $section->link,
            "html"                      => $section->html,
            "image_url"                 => ( isset($section->thumbnail_image->url ) ? $section->thumbnail_image->url : null),
            "iframe"                    => $section->iframe,
            "header_background_color"   => "#".$template->background_color,

        ])

    @endforeach

</div>
