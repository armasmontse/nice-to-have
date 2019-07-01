{!! Form::open([
      'method'              => 'PATCH',
      'action'              => ['Admin\Settings\ManageSettingController@update', 'event_expiration'],
      'role'                => 'form' ,
      'id'                  => 'update_setting-event_expiration_form',
    ]) !!}

    @include('admin.general._page-subtitle', ['title' => trans('manage_settings.event_expiration.title') ])

    <div class="col-xs-12 col-md-10 col-md-offset-1">

        <div class="row contact__row">

            <div class="col-xs-12 col-md-6">

                <div class="form-group">

                    {!! Form::label('time', trans('manage_settings.event_expiration.label'), ['class' => 'input-label']) !!}

                    {!! Form::number('time', $setting_event_expiration , [
                        'class'         => 'form-control input',
                        'form'          => 'update_setting-event_expiration_form',
                        'placeholder'   => trans('manage_settings.event_expiration.placeholder'),
                        'required'      => 'required',
                        'style'         => 'width: 70%;display:inline; margin-right: 5px;'
                    ]) !!}

                    <span>Meses. </span>
                </div>

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
