<div class="event__section-imagen_completa" style="background-color: {{ $background_color }};"
	@if($rules['title'])
		id="{{ str_slug($title) }}"
		data-scroll-index="{{ str_slug($title) }}"
	@endif
>

    {{-- title --}}
	@if ($rules["title"])
		<div class="{{"grid__container".$full_with}}">
            <div class="grid__col-1-1 event__col-1-1 block">
                <div class="event__title imagen_completa">
                    <h3>{{ $title }}</h3>
                </div>
            </div>
		</div>
    @endif


    {{-- link --}}
    @if ($rules["link"])
		<div class="{{"grid__container".$full_with}}">
            <div class="grid__col-1-1 event__col-1-1 block">
                <div class="event__map event__map-link ">
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
		</div>
    @endif

    {{-- html --}}
    @if ($rules["html"])
		<div class="{{"grid__container".$full_with}}">
            <div class="grid__col-1-1--sm event__col-1-1">
                <div class="event__paragraph">
                    {!! $html !!}
                </div>
            </div>
		</div>
    @endif

    {{-- imagen --}}
    @if ($rules["photo"])
		<div class="{{"grid__container".$full_with}}">
            <div class="grid__col-1-1 ">
                <img src="{{ $image_url }}" alt="" class=""/>
            </div>
		</div>
    @endif

    {{-- iframe --}}
    @if ( is_youtube_url($link) || is_google_maps_url($link))
		<div class="{{"grid__container".$full_with}}">
            <div class="grid__col-1-1 event__col-2-1">
                <div class="event__map imagen_completa">
                    <div class="canvas_JS imagen_completa">

						@if (is_youtube_url($link))
							<iframe src="{{ youtube_url_to_embed($link) }}"></iframe>
						@endif

						@if ( is_google_maps_url($link))
							<iframe
							  frameborder="0" style="border:0"
							  src="{{ google_maps_url_to_embed($link) }}" allowfullscreen>
							</iframe>
						@endif
                    </div>
                </div>
            </div>
		</div>
    @endif

</div>
