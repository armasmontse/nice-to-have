<div class="splash__row-container">
<div class="grid__row splash__row" style="background-image: url({{ isset($section->components[0]->thumbnail_image->url) ? $section->components[0]->thumbnail_image->url : asset('images/imagen-splash-3.jpg') }})">
	<div class="grid__container">
		<div class="grid__col-1-2 splash__col-1-2">
			<div class="grid__box splash__box splash__box--right">
				<h2 class="splash__ttl">{{ $section->components[1]->title }}</h2>
				<div class="splash__p splash__p--small">
					{!!$section->components[1]->content!!}
				</div>
				<div class="splash__button-main-container">
					<div class="splash__button-container">
						<a href="{{ route("client::event.register")}}" class="splash__button">
								<span class="splash__button-arrow">
									{!! file_get_contents('images/flechita-boton.svg') !!}
								</span>
								Haz tu mesa de regalos
						</a>
					</div>
				</div>
			</div>
		</div>
		<div class="grid__col-1-2 splash__col-1-2">
			<div class="grid__box splash__box">
				<h2 class="splash__ttl">{{ $section->components[2]->title }}</h2>
				<div class="splash__p splash__p--small">
					{!!$section->components[2]->content!!}
				</div>
				<div class="splash__button-main-container">
					<div class="splash__button-container">
						<a href="{{ route("client::shop.index") }}" class="splash__button">
								<span class="splash__button-arrow">
									{!! file_get_contents('images/flechita-boton.svg') !!}
								</span>
								Visita la tienda
						</a>
					</div>
					<div class="splash__button-container">
						<a href="{{ route("client::events.search") }}" class="splash__button">
								<span class="splash__button-arrow">
									{!! file_get_contents('images/flechita-boton.svg') !!}
								</span>
								Mesa de regalos
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>{{-- fin debug --}}
