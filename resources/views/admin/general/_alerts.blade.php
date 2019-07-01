<div id="alerts__container" class="alerts__container">

    <div id="alert__success" class="alert alert-success @unless (session('status') )  hidden @endunless alerts alerts__success">

        <button type="button" class="close alerts__close alert__hide_JS" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>

        <p class="alerts__text alerts--center-text">¡Éxito!</p>
        @if (session('status'))
            <p class="alerts__text alerts--center-text">{!! session('status') !!}</p>
        @endif
        <ul class="alerts--center-text">
            <li class="text__alert-success text__alert-success_JS alerts--center-text"></li>
            @if (isset($errors) && $errors->count() > 0)
                 @foreach ($errors->all() as $error)
                    <li class="text__alert-success alerts--center-text">{{ $error }}</li>
                @endforeach
            @endif
        </ul>

    </div>

    <div id="alert__danger" class="alert alert-danger @unless (isset($errors) && $errors->count() > 0) hidden @endunless alerts alerts__danger">

        <button type="button" class="close alerts__close alert__hide_JS" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>

        <p class="alerts__text alerts--center-text">¡Encontramos un error!</p>
        <ul class="alerts--center-text">
            <li class="alerts__text alerts--center-text"></li>
            @if (isset($errors) && $errors->count() > 0)
                 @foreach ($errors->all() as $error)
                    <li class="alerts__text alerts--center-text">{{ $error }}</li>
                @endforeach
            @endif
        </ul>

    </div>
</div>
