{!! Form::open([
      'method'              => 'PATCH',
      'action'              => ['Admin\Settings\ManageSettingController@update', 'checkout_min'],
      'role'                => 'form' ,
      'id'                  => 'update_setting-checkout_min_form',
    ]) !!}

    @include('admin.general._page-subtitle', ['title' => trans('manage_settings.checkout_min.title') ])

    <div class="col-xs-12 col-md-10 col-md-offset-1">

        <div class="row contact__row">

            <div class="col-xs-12 col-md-6">

                <div class="form-group">

                    {!! Form::label('percentage', trans('manage_settings.checkout_min.label'), ['class' => 'input-label']) !!}

                    {!! Form::number('percentage', $setting_checkout_min , [
                        'class'         => 'form-control input',
						'min'			=> 0,
						'max'			=> 100,
						'step'			=> 1,
                        'form'          => 'update_setting-checkout_min_form',
                        'placeholder'   => trans('manage_settings.checkout_min.placeholder'),
                        'required'      => 'required',
                        'style'         => 'width: 85%;display:inline; margin-left: 5px;'
                    ]) !!}

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
