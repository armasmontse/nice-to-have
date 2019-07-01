<div class="" style="background-color: {{ $background_color }};" >

    <div class="">

        <div class="event__cover-page" style="background-image: url({{  $image_url }});background-color: {{ $image_background_color }};"  ></div>

        <div class="grid__container">
            <div class="grid__col-1-1--sm event__col-1-1">
                <div class="event__main-section">
                    <h1 class="event__name">{{$name}}</h1>
                    @if ($timer_show)
                        @include('client.events.templates.general.timer')
                    @endif
                   {{-- @include('client.events.templates.general.send_to_facebook') --}}
                    @include('client.events.templates.general.mesa_regalos')
                </div>
            </div>
        </div>

    </div>

    <div class="divisor"></div>

    <div class="grid__container">
        <div class="grid__col-1-1--sm event__col-1-1">
            <div class="event__confirmation-form">
                <p class="event__countdown--sm">{{$date->formatLocalized('%d - %b - %Y')}}</p>
                <div class="event__paragraph">
                    {!! $description !!}
                </div>
                @include('client.events.templates.general.confirmation_form')
            </div>
        </div>
    </div>

    <div class="event--info grid__container">
        <ul class="event__menu">
            @foreach ($sections as $section)
                @if ($section->eventTemplateSectionType->rules['title'])
                    <li class="event__menu--item">
                        <a href="#{{ str_slug($section->title) }}" data-scroll-nav="{{ str_slug($section->title) }}">{{ $section->title }}</a>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>

</div>
