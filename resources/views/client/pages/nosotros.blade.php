{{-- Usar para About. Éste es el bueno --}}
@extends('layouts.client', ['body_id'	=> 	'main-vue', 'body_class' => 'home__body'])

@section('title')
	| Nosotros
@endsection

@section('content')
	
	{{-- Botón ScrollUp --}}
	@include('client.general.scroll-up-icon')

	{{-- 3 images --}}
	{{-- @include('client.home.partials.three-images', ['img_1' => 'images/home/franja_3.jpg', 'img_2'	=> 	'images/home/franja_3-1.jpg', 'img_3'	=> 	'images/home/franja_3-2.jpg']) --}}

	{{-- Lema/CTA --}}
	<section class="home__intro" style="background-image: url({{asset('images/imagen-splash-4.jpg')}})">
		<div class="grid__container home__container--cta">
			<div class="grid__col-1-1--sm home__col-1-1--cta">
				<div class="home__box home__box--cta">
					<h3 class="home__ttl home__ttl--cta">NICE TO HAVE es una tienda de regalos para todos los que amamos que las experiencias y productos nos cuenten historias, porque son historias que nosotros contaremos a su vez. Para los que valoramos las horas de diseño y para los que lo estético y bonito nos llena el corazón.</h3>
				</div>
			</div>
		</div>
	</section>

	{{-- Paso 1 --}}
	@include('client.home.partials.steps', [
		'container__class'	=> 	'home__container--steps--pt-smaller',
		'title' 	=>	'Crea tu evento',
		'number' 	=> 	'Paso 1',
		'content' 	=> 	'<p>Cualquier pretexto es bueno para festejar y merece un regalo para la ocasión. Crea un evento y diseña una página personalizada en la que NICE TO HAVE es tu mesa de regalos.</p>'
		])

	{{-- 2 images --}}
	<section class="grid__container--full-width home__container--full-width">
		<div class="grid__col-1-2 home__col-1-2">
			<div class="home__box" style="background-image: url({{asset('images/home/franja_1.jpg')}})"></div>
		</div>
		<div class="grid__col-1-2 home__col-1-2">
			<div class="home__box" style="background-image: url({{asset('images/home/franja_1-1.jpg')}})"></div>
		</div>
	</section>

	{{-- Paso 2 --}}
	@include('client.home.partials.steps', [
		'title' 	=>	'Recibe regalos',
		'number' 	=> 	'Paso 2',
		'content' 	=> 	'<p>Comparte el link de tu evento con tus invitados y recibe regalos que tomaron horas para ser diseñados y que por lo tanto tienen una historia que contar.</p>
						 <p>Al crear tu evento, podrás gozar de <a href="'.route("client::pages.show","preguntas-frecuentes").'" class="home__link home__link--capital-letter">otros beneficios.</a></p>'
		])

	{{-- 3 imagenes --}}
	@include('client.home.partials.three-images', ['img_1' => 'images/home/franja_2-1.jpg', 'img_2'	=> 	'images/home/franja_2-2.jpg', 'img_3'	=> 	'images/home/franja_2.jpg',])

	{{-- Paso 3 --}}
	@include('client.home.partials.steps', [
		'container__class'	=> 	'home__container--steps--pb-small',
		'title' 	=>	'Regala diferente',
		'number' 	=> 	'Paso 3',
		'content' 	=> 	'<p>Entre a la tienda en línea de NICE TO HAVE y regala diferente, ya sea que quieras regalarte algo a ti o para alguien más. Nuestra tienda está disponible todo el año y tiene productos para cualquier ocasión.
						</p>'
		])
	{{--  CTA --}}
	<div class="grid__container home__container--cta-buttons-main-container pt0">
		<div class="grid__col-1-1">
			<div class="home__cta-buttons-container home__cta-buttons-container--small">
				<a class="input__submit">crea tu evento</a>
				<a href="{{route('client::shop.index')}}" class="input__submit">Ir a la tienda</a>
			</div>
		</div>
	</div>

	{{-- Contacto --}}
	<section class="relative" id="contacto">
		<div class="grid__container home__container--contacto">
			<div class="grid__col-1-1--sm home__col-1-1--contacto">
				<div class="home__box home__box--cta">

                    {!! Form::open(['method' => 'POST', 'route' => 'client::pages.contacto:post' ]) !!}

                        <h3 class="home__ttl--contact">Contáctanos</h3>
				<div class="home__p--contact">
					<p>Plaza Río de Janeiro 60BIS, Int. A, Col. Roma Norte, <br> Del. Cuauhtémoc,</p>
					<p>CP. 06700, CDMX</p>
					<a href="callto:555555" class="home__p--telephone">T. 55 35 55 00 92 / 55 65 88 88 38</a> <br>
					<a href="mailto:info@nicetohave.mx" class="home__p--telephone">M. contacto@nicetohave.com.mx</a>
					<p>Lunes a Sábados 10 am a 2 pm / 4 pm a 6pm</p>
				</div>
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

                        {{-- <div class="home__contacto-buttons-container home__contacto-checkboxes-container">
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
    					</div> --}}

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
