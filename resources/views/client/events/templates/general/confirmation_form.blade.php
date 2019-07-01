{!! Form::open([
    'method' => 'POST',
    'route' => ['client::events.confirm',  $event->slug ],
    ]) !!}

    <div class="event__title">
        <h3>{{ trans('events.templates.info_ttl') }}</h3>
    </div>
    <p class="event__paragraph">{{ trans('events.templates.info_rsvp') }}</p>

    <div class="event__input-container">
        {!! Form::email('email', null, [
            'class'         => 'input event__input',
            'required'      => 'required',
            'placeholder'   => trans('events.templates.rsvp_email')
        ]) !!}

        {!! Form::text('inputname', null, [
            'class'         => 'input event__input',
            'required'      => 'required',
            'placeholder'   => trans('events.templates.rsvp_names')
        ]) !!}
        <p class="event__paragraph--sm">{{ trans('events.templates.rsvp_help') }}</p>
    </div>

    {!! app('captcha')->display($attributes = [], $lang = 'es-419'); !!}

    {!! Form::submit('enviar', ['class' => 'input__submit-dark event__button']) !!}

{!! Form::close() !!}
