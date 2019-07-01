{{-- Contacto --}}
<section class="relative" id="contacto">
	<div class="grid__container home__container--contacto">
		<div class="grid__col-1-1--sm home__col-1-1--contacto">
			<div class="home__box home__box--cta">

                {!! Form::open(['method' => 'POST', 'route' => 'client::pages.contacto:post']) !!}

                    <h3 class="home__ttl--contact home__ttl--contact--small">{!! $section->components[0]->title !!}</h3>
        			<div class="wysiwyg home__p--contact home__p--contact--small">
                        {!! $section->components[0]->content !!}
        			</div>

                    {!! Form::text('full_name', null, [
                        'class'         => 'input',
                        'required'      => 'required',
                        'placeholder'   => 'Nombre y apellido'
                    ]) !!}

                    {!! Form::email('email', null, [
                        'class'         => 'input',
                        'required'      => 'required',
                        'placeholder'   => 'Correo electrónico'
                    ]) !!}

                    {!! Form::tel('phone', null, [
                        'class'         => 'input',
                        'required'      => 'required',
                        'placeholder'   => 'Teléfono'
                    ]) !!}

                    {!! Form::textarea('message', null, [
                        'class'         => 'input',
                        'required'      => 'required',
                        'style'         => 'margin-top: 10px; height: auto; max-height: 60px;',
                        'placeholder'   => 'Mensaje'
                    ]) !!}

					<div class="home__contacto-buttons-container">
                        {!! Form::submit('Enviar', ['class' => 'input__submit']) !!}
					</div>

                {!! Form::close() !!}

			</div>
		</div>
	</div>
	<div class="grid__row home__row--contacto--black"></div>
</section>
