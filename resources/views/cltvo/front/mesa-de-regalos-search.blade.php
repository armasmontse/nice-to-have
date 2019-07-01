@extends('layouts.client', ['user' => true])

@section('content')
<div class="grid__row login__row">
	<div class="grid__container login__container">
		<div class="grid__col-1-1 grid__col-1-1--sm">
			<div class="grid__box login__box">
				<div class="login__title-container">
				<span class="mesa-de-regalos__search-title">Encuentra una mesa de regalos con el nombre del festejado o número de su evento.</span>
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
@endsection
