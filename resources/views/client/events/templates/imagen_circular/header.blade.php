<div class="event"  style="background-color:{{ $background_color }};" >
	<div class="event--grid">

		<div class="event--main grid__container">

			<div class="event__meta">

				<div class="event__meta--name-container">
					<h1 class="event__meta--name" style="color:{{$background_color}}">
						{{ $name }}
					</h1>
				</div>

				<div class="event__meta--registry-btn">
					@include('client.events.templates.general.mesa_regalos')
				</div>

				@if ($timer_show)
					<div class="event__meta--timer">
						@include('client.events.templates.imagen_circular.timer')
					</div>
				@endif

				<!-- <div class="even__meta--send-to-fb">
					{{-- @include('client.events.templates.general.send_to_facebook') --}}
				</div> -->

			</div>

			<div class="event__img--container">
				<div class="event__img" style="background-image:url({{  $image_url }});"></div>
			</div>

		</div>

		<div class="event--info grid__container">

			<div class="event__txt grid__col-1-2">
				<p class="event__txt--ttl">{{ $date->format('d F, Y') }} &mdash; {{ $date->format('h:i A') }}</p>
				<div class="event__txt--description">{!! $description !!}</div>
			</div>

			<div class="event__txt grid__col-1-2">
				<p class="event__txt--ttl">{{ trans('events.templates.info_ttl') }}</p>
				<div class="event__txt--description">{{ trans('events.templates.info_rsvp') }}</div>

				{!! Form::open([
				    'method'=> 'POST',
				    'route' => ['client::events.confirm', $event->slug ],
					'class'	=> 'event__rsvp'
				]) !!}

					{!! Form::email('email', null, [
			            'class'         => 'event__rsvp--input input',
			            'required'      => 'required',
			            'placeholder'   => trans('events.templates.rsvp_email')
			        ]) !!}

			        {!! Form::text('inputname', null, [
			            'class'         => 'event__rsvp--input input',
			            'required'      => 'required',
			            'placeholder'   => trans('events.templates.rsvp_names')
			        ]) !!}

					<p class="event__rsvp--help">{{ trans('events.templates.rsvp_help') }}</p>

				    {!! app('captcha')->display($attributes = [], $lang = 'es-419'); !!}

				    {!! Form::submit('enviar', ['class' => 'input__submit-dark event__button']) !!}

				{!! Form::close() !!}
			</div>

		</div>

		<div class="event--info grid__container">
			<ul class="event__menu">
				@foreach ($sections as $section)
					@if ($section->eventTemplateSectionType->rules['title'])
						<li class="event__menu--item">
							<a href="#{{ str_slug($section->title) }}" data-scroll-nav="{{ str_slug($section->title) }}">{{ $section->title }}</a>
						</li>
					@endif
				@endforeach
			</ul>
		</div>

	</div>
</div>
