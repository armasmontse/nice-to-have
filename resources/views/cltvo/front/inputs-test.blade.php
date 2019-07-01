@extends('layouts.test-client')

@section('content')
<style type="text/css">
	.padding {
		padding: 10px;
	}
	.w50 {
		width: 50%;
	}
</style>
<div class="padding w50">
	<input class="input" type="text" placeholder="Nombre y Apellido" name="">
	<input class="input" type="text" placeholder="Nombre y Apellido" name="">
	<input class="input" type="text" placeholder="Nombre y Apellido" name="">
	<textarea class="input__textarea" placeholder="textarea"></textarea>
	<input type="submit" class="input__submit" value="Input">
	<span class="input__submit">Span</span>
	<button class="input__submit">Button</button>
	<button class="input__submit" style="width:200px">Button <span class="input__submit-icon">+</span></button>
	<div class="input__checkbox-container">
		<label class="input__checkbox-label">Label</label>
		<input class="input__checkbox" type="checkbox">
	</div>
	<div class="input__checkbox-container">
		<input class="input__checkbox" type="checkbox">
		<label class="input__checkbox-label">Label</label>
	</div>
	<div class="input__select-container">
		<select class="input__select">
			<option value="1" class="input__option">Comprar para mesa de regalos</option>
			<option value="" class="input__option">Comprar y reglar</option>
			<option value="" class="input__option">Comparar para mi</option>
		</select>
		{!! file_get_contents('images/flecha-select.svg') !!}
	</div>
</div>

@endsection
