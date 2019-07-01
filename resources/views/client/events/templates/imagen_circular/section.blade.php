<div class="event" style="background-color: {{ $background_color }};"
	@if($rules['title'])
		id="{{ str_slug($title) }}"
		data-scroll-index="{{ str_slug($title) }}"
	@endif
>
	<div class="event--grid">

		<div class="event__section grid__container">

			{{-- title --}}
			@if ($rules["title"])
				<div class="event__section--ttl-container">
					<h3 class="event__section--ttl" style="color: {{ $header_background_color }}">
						{{ $title }}
					</h3>
				</div>
			@endif


			{{-- iframe link --}}
			@if (is_youtube_url($link) || is_google_maps_url($link))
				<div class="event__map canvas_JS event__section--iframe @if(is_youtube_url($link)) {{ "iframe--16by9" }} @else {{ "iframe--10by3" }} @endif" style="background-color: {{ $header_background_color }};">
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
			@endif

			{{-- link --}}
			@if ($rules["link"])
				<div class="event__map-link" style="display: none;">
					<a href="{{ $link }}" target="_blank">
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
			@endif

			{{-- html --}}
			@if ($rules["html"])
				<div class="event__section--html">
					{!! $html !!}
				</div>
			@endif

			{{-- imagen --}}
			@if ($rules["photo"])
				<img src="{{ $image_url }}" alt="" class="event__section--img"/>
			@endif

		</div>

	</div>
</div>
