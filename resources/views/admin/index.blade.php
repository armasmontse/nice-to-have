@extends('layouts.admin')

@section('title')
	Administrador
@endsection

@section('h1')
	¡Hola, {{ $user->first_name }}!
@endsection

@section('content')

	<div class="col-xs-10 col-xs-offset-1">
		@include('admin.general._page-instructions', [
			'title'			=> 'Manual de uso',
			'instructions'	=> 'Da click en alguno de los enlaces para administrar su contenido.'
		])

		<div class="row" style="display:none;">
			<div class="col-xs-10 col-xs-offset-1">
				<ol>
					<li><a href="https://youtu.be/SKbO1A7YWAA" target="_blank" class="link">NTH - Productos</a></li>
				</ol>
			</div>
		</div>
	</div>

	<div class="row welcome">
		@foreach ( $items as $item )
			@if ($user->hasPermission($item['permission']))
				<a class="col-xs-4 welcome__item" href="{{ route('admin::'.$item['route_name']) }}">
					<i class="fa welcome__item--icon">{{ $item['icon'] }}</i>
					<span class="welcome__item--label">{{ $item['label'] }}</span>
				</a>
			@endif
		@endforeach
	</div>

@endsection
