<div class="grid__row">
    <div class="grid__container">
        <div class="grid__col-1-2" style="height: 500px; background-color: pink;">
            <div class="grid__box general-event__box" style="height: 500px; background-color: green">
                <p>selecciona un tipo de vento</p>

                <div class="input__select-container">
                    {!! Form::select('inputname', ['boda'], null, [
                        'class' => 'input__select',
                        'required' => 'required',
                    ]) !!}

                    {!! file_get_contents('images/flecha-select.svg') !!}
                </div>

                <p>selecciona una variación</p>

                <div class="input__select-container">
                    {!! Form::select('inputname', ['ella + ella'], null, [
                        'class' => 'input__select',
                        'required' => 'required',
                    ]) !!}

                    {!! file_get_contents('images/flecha-select.svg') !!}
                </div>

                @include('client.events.partials.info-form')
            </div>
        </div>
        <div class="grid__col-1-2 general-event__col-1-2" style="height: 500px; background-color: blue;">
            <div class="grid__box general-event__box" style="height: 500px; background-color: yellow"></div>
        </div>
    </div>
</div>
