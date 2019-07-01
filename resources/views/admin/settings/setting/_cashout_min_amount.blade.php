{!! Form::open([
      'method'              => 'PATCH',
      'action'              => ['Admin\Settings\ManageSettingController@update', 'cashout_min_amount'],
      'role'                => 'form' ,
      'id'                  => 'update_setting-cashout_min_amount_form',
    ]) !!}

    @include('admin.general._page-subtitle', ['title' => trans('manage_settings.cashout_min_amount.title') ])

    <div class="col-xs-12 col-md-10 col-md-offset-1">

        <div class="row contact__row">

            <div class="col-xs-12 col-md-6">

                <div class="form-group">

                    {!! Form::label('min_amount', trans('manage_settings.cashout_min_amount.label'), ['class' => 'input-label']) !!}

                    <br> <span>$ </span>

                    {!! Form::number('min_amount', $setting_cashout_min_amount , [
                        'class'         => 'form-control input',
						'min'			=> 0,
						'step'			=> 0.01,
                        'form'          => 'update_setting-cashout_min_amount_form',
                        'placeholder'   => trans('manage_settings.cashout_min_amount.placeholder'),
                        'required'      => 'required',
                        'style'         => 'width: 85%;display:inline; margin-left: 5px;'
                    ]) !!}

                    <span>MXN </span>

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
