@extends('layouts.client')

@section('content')

<div class="grid__row login__row create-event__row" @if(isset($image->thumbnail_image) && isset($image->thumbnail_image->url)) style="background-image: url('{{ $image->thumbnail_image->url }}'); @endif">
	<div class="grid__container login__container">
		<div class="grid__col-1-1 grid__col-1-1--sm">
			<div class="grid__box login__box">

				<div class="login__title-container">
					<span class="mesa-de-regalos__search-title mesa-de-regalos__search-title--small">
						{!! $search_search_message_copy !!}
					</span>
				</div>

				<form role="form" method="get" action="{{ route('client::events.search') }}">

					<div class="login__input-container">
						<input id="search" type="text" class="input" placeholder="Busca un evento" name="s" value="" required autofocus>
					</div>

					<div class="login__button-container">
						<button type="submit" class="input__submit" >Consultar</button>
					</div>

				</form>

			</div>
		</div>
	</div>
</div>

@endsection
