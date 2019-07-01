{!! Form::open([
      'method'              => 'PATCH',
      'action'              => ['Admin\Settings\ManageSettingController@update', 'exchange_rate'],
      'role'                => 'form' ,
      'id'                  => 'update_setting-exchange_rate_form',
    ]) !!}

    @include('admin.general._page-subtitle', ['title' => trans('manage_settings.exchange_rate.title') ])

    <div class="row contact__row">
        <div class="col-xs-10 col-md-5 col-md-offset-1">
            <div class="form-group">

                {!! Form::label('US[currency]', trans('manage_settings.exchange_rate.US.currency.label'), ['class' => 'input-label']) !!}

                {!! Form::text('US[currency]', array_get($setting_exchange_rate,'US.currency'), [
                    'class'         => 'form-control input',
                    'form'          => 'update_setting-exchange_rate_form',
                    'placeholder'   => trans('manage_settings.exchange_rate.US.currency.placeholder'),
                    'required'      => 'required',
                ]) !!}
            </div>
        </div>
        <div class="col-xs-10 col-md-5">
            <div class="form-group">
                {!! Form::label('US[exchange]', trans('manage_settings.exchange_rate.US.exchange.label'), ['class' => 'input-label']) !!}
                {!! Form::text('US[exchange]', array_get($setting_exchange_rate,'US.exchange'), [
                    'class'         => 'form-control input',
                    'form'          => 'update_setting-exchange_rate_form',
                    'placeholder'   => trans('manage_settings.exchange_rate.US.exchange.placeholder'),
                    'required'      => 'required',
                ]) !!}
            </div>
        </div>
    </div>

    <br>

    <div class="row">
        <div class="col-xs-2 col-xs-offset-9">
            {!! Form::submit(trans('manage_settings.general.save'), ['class' => 'btn btn-info button']) !!}
        </div>
    </div>

{!! Form::close() !!}
