@extends('layouts.client', ['body_id' => 'main-vue'])

@section('title')
| Búsqueda
@endsection

@section('content')
<div class="grid__row">
	@include('client.general.page-title', ['title' => 'Resultado de Búsqueda de Eventos'])

	<div class="grid__container mesa-de-regalos__search-container mesa-de-regalos__search-container--pt-sm">
		<div class="grid__col-1-1 grid__col-1-1--sm">
			<div class="grid__box">
				<div class="login__title-container">

					<form role="form" method="get" action="{{ route('client::events.search') }}">
						{{-- {{ csrf_field() }} --}}

						<div class="login__input-container">
							<input id="search" type="text" class="input" placeholder="Busca un evento" name="s" value="{{ $search_words }}" required autofocus>
						</div>

						<div class="login__button-container">
							<button type="submit" class="input__submit" >Consultar</button>
						</div>
					</form>

				</div>
			</div>
		</div>
	</div>
</div>

<div class="grid__row">
	<div class="grid__container mesa-de-regalos__container--users">


		@forelse ($events as $pubic_event)
			<div class="grid__col-1-4">
				<div class="grid__box">
					<div class="users__user-container mesa-de-regalos__user-container">
					    <div class="users__event-name-container">
					    {{-- un modelo de la integración está en client.users.show, esto es casi una copia del mismo--}}
					        <span class="users__text--data users__text--data-block-hira">{{ $pubic_event->name }}</span>
					    </div>

					    <div class="users__general-info-container">
					        <span class="users__text--data users__text--data-block-hira">{{  $pubic_event->date->format("d/m/Y")  }}</span>
					        <span class="users__text--data users__text--data-block-hira">No: <span style="text-transform: uppercase;">{{ $pubic_event->key }}</span></span>
					        <span class="users__text--data users__text--data-block-hira">Tipo de evento: {{ $pubic_event->type_label }}</span>
					    </div>

						{{-- solo cuando el evento tiene pagina  // falta integrar --}}
						@if ( $pubic_event->template_is_publish )
							<div class="users__link-container">
								<a href="{{ $pubic_event->public_url }}" class="users__link">Ver página del evento</a>
							</div>
						@endif

						<div class="users__link-container">
					        <a href="{{ $pubic_event->shop_url }}" class="input__submit mesa-de-regalos__button">
					        	<span class="mesa-de-regalos__button-icon">
					        		{!! file_get_contents('images/icon-regalo.svg')!!}
					        	</span>
					        	Mesa de Regalos
					        </a>
					    </div>

					    <div class="divisor"></div>
					</div>
				</div>
			</div>
		@empty
			<div class="info-section__p" style="margin: 0 auto;">
				<center>
					{!! $search_without_results_copy !!}
				</center>
			</div>
		@endforelse

	</div>
</div>
@endsection
