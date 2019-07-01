@extends('layouts.client', ['body_id' => 'main-vue'])

@section('title')
| Carritos
@endsection

@section('content')
<div class="grid__row">
	@include('client.general.page-title', ['title' => 'Resultado de Búsqueda de Eventos'])

	<div class="grid__container mesa-de-regalos__search-container">
		<div class="grid__col-1-1 grid__col-1-1--sm">
			<div class="grid__box">
				<div class="login__title-container">
				<span class="mesa-de-regalos__search-title">Encuentra una mesa de regalos <br class='mesa-de-regalos__search-br'>con el nombre del festejado o número de su evento.</span>
				</div>

				<form role="form" method="POST" action="{{ route('client::login:post') }}">
					{{ csrf_field() }}

					<div class="login__input-container">
						<input id="search" type="search" class="input" placeholder="Busca un evento" name="search" value="" required autofocus>
					</div>

					<div class="login__button-container">
						<button type="submit" class="input__submit" name="button">Consultar</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="grid__row">
	<div class="grid__container mesa-de-regalos__container--users">
		<div class="grid__col-1-4" v-for="i in [1,2,3,4,5,6,7]">
			<div class="grid__box">
				<div class="users__user-container mesa-de-regalos__user-container">
				    <div class="users__event-name-container">
				    {{-- un modelo de la integración está en client.users.show, esto es casi una copia del mismo--}}
				        <span class="users__text--data users__text--data-block-hira">María Fernanda González y José Manuel Mejía</span>
				    </div>

				    <div class="users__general-info-container">
				        <span class="users__text--data users__text--data-block-hira">08/02/2017</span>
				        <span class="users__text--data users__text--data-block-hira">No: HASAL7282393</span>
				        <span class="users__text--data users__text--data-block-hira">Tipo de evento: Boda</span>
				    </div>

				    <div class="users__link-container">
				        <a href="#" class="users__link">Ver página del evento</a>
				    </div>
					
					<div class="users__link-container">
				        <a href="#" class="input__submit mesa-de-regalos__button">
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
	</div>
</div>
@endsection
