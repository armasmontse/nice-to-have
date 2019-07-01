<div class="event" style="background-color: {{ $background_color }};"
	@if($rules['title'])
		id="{{ str_slug($title) }}"
		data-scroll-index="{{ str_slug($title) }}"
	@endif
>
    <div class="{{"grid__container".$full_with}}">

    {{-- title --}}
        @if ($rules["title"])
            <div class="grid__col-1-1">
                <div class="event__title">
                    <h3>{{ $title }}</h3>
                </div>
            </div>
        @endif

    {{-- html --}}
        @if ($rules["html"])
            <div class="grid__col-1-1--sm event__col-1-1">
                <div class="event__section event__paragraph">
                    {!! $html !!}
                </div>
            </div>
        @endif

    {{-- imagen --}}
        @if ($rules["photo"])
            <div class="grid__col-1-1">
                <img src="{{ $image_url }}" alt="" class="event__image"/>
            </div>
        @endif

	{{-- link --}}
        @if ($rules["link"])
            <div class="grid__col-1-1">
                <div class="event__map event__map-link">
					<a class="event__paragraph" href="{{ $link }}" target="_blank">
						Abrir en
						@if (is_youtube_url($link))
							 youtube
						@elseif (is_google_maps_url($link))
							google
						@else
							nueva pestaña
						@endif
					</a>
                </div>
            </div>
        @endif

    {{-- iframe --}}
        @if (is_youtube_url($link) || is_google_maps_url($link))
            <div class="grid__col-1-1">
                <div class="event__map canvas_JS event__section--iframe @if(is_youtube_url($link)) {{ "iframe--16by9" }} @else {{ "iframe--10by3" }} @endif">
                    @if (is_youtube_url($link))
						<iframe src="{{ youtube_url_to_embed($link) }}" class="iframe--youtube"></iframe>
					@endif

					@if ( is_google_maps_url($link))
						<iframe
						  frameborder="0" style="border:0"
						  src="{{ google_maps_url_to_embed($link) }}" class="iframe--google" allowfullscreen>
						</iframe>
					@endif
                </div>
            </div>
        @endif

    </div>
</div>
