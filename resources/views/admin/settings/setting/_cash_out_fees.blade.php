{!! Form::open([
      'method'              => 'PATCH',
      'action'              => ['Admin\Settings\ManageSettingController@update', 'cash_out_fees'],
      'role'                => 'form' ,
      'id'                  => 'update_setting-cash_out_fees_form',
    ]) !!}

    @include('admin.general._page-subtitle', ['title' => trans('manage_settings.cash_out_fees.title') ])

    <div class="col-xs-12 col-md-10 col-md-offset-1">

        <div class="row contact__row">

            <div class="col-xs-12 col-md-6">

                <div class="form-group">

                    {!! Form::label('exclusive', trans('manage_settings.cash_out_fees.exclusive.label'), ['class' => 'input-label']) !!}

                    {!! Form::number('exclusive', $setting_cash_out_fees["exclusive"] , [
                        'class'         => 'form-control input',
						'min'			=> 0,
						'max'			=> 100,
						'step'			=> 0.1,
                        'form'          => 'update_setting-cash_out_fees_form',
                        'placeholder'   => trans('manage_settings.cash_out_fees.placeholder'),
                        'required'      => 'required',
                        'style'         => 'width: 85%;display:inline; margin-left: 5px;'
                    ]) !!}

                </div>
				<div class="form-group">

					{!! Form::label('not_exclusive', trans('manage_settings.cash_out_fees.not_exclusive.label'), ['class' => 'input-label']) !!}

					{!! Form::number('not_exclusive', $setting_cash_out_fees["not_exclusive"] , [
						'class'         => 'form-control input',
						'min'			=> 0,
						'max'			=> 100,
						'step'			=> 0.1,
						'form'          => 'update_setting-cash_out_fees_form',
						'placeholder'   => trans('manage_settings.cash_out_fees.not_exclusive.placeholder'),
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
