{{--- ========== No usar ============= --}}

@extends('layouts.client', ['body_id'	=> 	'main-vue'])

@section('title')
	| Home
@endsection

@section('content')


{{-- Imágenes --}}
	<section class="grid__container">
		<div class="grid__col-1-2 home__col-1-2 home__col-1-2--higher">
			<div class="home__box" style="background-image: url({{asset('images/home/franja_1.jpg')}})"></div>
		</div>
		<div class="grid__col-1-2 home__col-1-2 home__col-1-2--higher">
			<div class="home__box" style="background-image: url({{asset('images/home/franja_1-1.jpg')}})"></div>
		</div>
	</section>


{{-- texto ejemplos y CTA --}}
	<div class="grid__container home__container--steps  home__container--steps--pt-smaller pb0">
		<div class="grid__col-1-1 home__col-1-1--ejemplos">
			<div class="home__p--steps" style="margin-bottom: 84px;">
				<p>
					Estos son algunos ejemplos de lo que puedes crear en tu Página de evento.
				</p>
			</div>
			<a href="#" class="input__submit"> Comienza y crea tu evento</a>
		</div>
	</div>

{{-- Paso 1 --}}
	@include('client.home.partials.steps', [
		'container__class'	=> 	'home__container--steps--pt-small',
		'title' 				=>	'Crea tu evento',
		'number' 			=> 	'Paso 1',
		'content' 			=> 	'<p>Todos tenemos algo que celebrar, pretextos hay miles. </br>
							Desde una boda, un cumpleaños o hasta una fiesta infantil. </br>
							Cualquier tipo de celebración es motivo suficiente para festejar con NICE TO HAVE.
						</p>
						<p>Crea tu evento y diseña una página personalizada. </br>
							Agrega todo tipo de información, fotos y datos curiosos sobre tu celebración.
						</p>'
		])

{{-- Imágenes --}}
	@include('client.home.partials.three-images', ['img_1' => 'images/home/franja_2-1.jpg', 'img_2'	=> 	'images/home/franja_2-2.jpg', 'img_3'	=> 	'images/home/franja_2.jpg',])

{{-- Paso 2 --}}
	@include('client.home.partials.steps', [
		'title' 	=>	'Recibe regalos',
		'number' 	=> 	'Paso 2',
		'content' 	=> 	'<p>Si siempre estás buscando algo que le de un toque distinto a tu casa o a la rutina, comparte el </br>
							link de tu evento con tus invitados.
						 </p>
						 <p>Recibirás regalos creados por gente que tiene una filosofía detrás de cada detalle, además de </br>
						   un sentido importante por la estética y las tendencias.
						 </p>
						 <p>Beneficios de crear un evento en NICE TO HAVE. </br>
						 	<a href="'.route("client::pages.show","preguntas-frecuentes").'" class="home__link">Click aquí</a>
						 </p>'
		])

{{-- Imágenes --}}
	@include('client.home.partials.two-images', ['img_1' => 'images/home/franja_3.jpg', 'img_2'	=> 	'images/home/franja_3-1.jpg'])

{{-- Paso 3--}}
	@include('client.home.partials.steps', [
		'title' 	=>	'Regalos y/o efectivo',
		'number' 	=> 	'Paso 3',
		'content' 	=> 	'<p>Cualquier persona puede comprar un regalo en NICE TO HAVE, en cualquier momento, para <br>
							cualquier persona y para cualquier ocasión, incluso para ti.
						</p>'
		])
{{--  CTA --}}
			<div class="grid__container home__container--steps  pt0">
				<div class="grid__col-1-1">
					<a href="#" class="input__submit"> Comienza y crea tu evento</a>
				</div>
			</div>

{{-- Contacto --}}
	<section class="relative">
		<div class="grid__container home__container--contacto">
			<div class="grid__col-1-1--sm home__col-1-1--contacto">
				<div class="home__box home__box--cta">

                    {!! Form::open(['method' => 'POST', 'route' => 'client::pages.contacto:post' ]) !!}

                        <h3 class="home__ttl--contact">Contáctanos</h3>

                        {!! Form::text('full_name', null, [
                            'class'         => 'input',
                            'required'      => 'required',
                            'placeholder'   => 'Nombre y apellido',
                        ]) !!}

                        {!! Form::email('email', null, [
                            'class'         => 'input',
                            'required'      => 'required',
                            'placeholder'   => 'Correo electrónico',
                        ]) !!}

                        {!! Form::tel('phone', null, [
                            'class'         => 'input',
                            'required'      => 'required',
                            'placeholder'   => 'Teléfono',
                        ]) !!}

                        {!! Form::text('message', null, [
                            'class'         => 'input',
                            'required'      => 'required',
                            'placeholder'   => 'Mensaje',
                        ]) !!}

                        <div class="home__contacto-buttons-container home__contacto-checkboxes-container">
    						<div class="input__checkbox-container">
                                {!! Form::checkbox('interest[crear]', 'crear', null, [
                                    'id'    => 'crear',
                                    'class' => 'input__checkbox',
                                ]) !!}
    							<label class="input__checkbox-label" for="crear">Crear evento</label>

    						</div>
    						<div class="input__checkbox-container">
                                {!! Form::checkbox('interest[comprar]', 'comprar', null, [
                                    'id'    => 'comprar',
                                    'class' => 'input__checkbox',
                                ]) !!}
    							<label class="input__checkbox-label" for="comprar">Comprar</label>
    						</div>
    						<div class="input__checkbox-container">
                                {!! Form::checkbox('interest[proveer]', 'proveer', null, [
                                    'id'    => 'proveer',
                                    'class' => 'input__checkbox',
                                ]) !!}
    							<label class="input__checkbox-label" for="proveer">Ser proveedor</label>
    						</div>
    					</div>

    					<div class="home__contacto-buttons-container">
                            {!! Form::submit("Enviar", ['class' => 'input__submit']) !!}
    					</div>

                    {!! Form::close() !!}

				</div>
			</div>
		</div>
		<div class="grid__row home__row--contacto--black"></div>
	</section>
@endsection
