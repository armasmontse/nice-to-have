{!! Form::open([
      'method'              => 'PATCH',
      'action'              => ['Admin\Settings\ManageSettingController@update', 'shipment'],
      'role'                => 'form' ,
      'id'                  => 'update_setting-shipment_form',
    ]) !!}

    @include('admin.general._page-subtitle', ['title' => trans('manage_settings.shipment.title') ])

    <div class="row contact__row">

        {{--  Street 1 --}}
        <div class="col-xs-12 col-md-5 col-md-offset-1">
            <div class="form-group">

                {!! Form::label('origin-address[street-1]', trans('manage_settings.shipment.origin-address.street-1.label'), ['class' => 'input-label']) !!}

                {{-- <small class="text__p text__p--description text__p--description-contact">{{ trans('manage_settings.shipment.origin-address.street-1.helper') }}</small> --}}

                {!! Form::text('origin-address[street-1]', array_get($setting_shipment,'origin-address.street-1'), [
                    'class'         => 'form-control input',
                    'form'          => 'update_setting-shipment_form',
                    'placeholder'   => trans('manage_settings.shipment.origin-address.street-1.placeholder'),
                    'required'      => 'required',
                ]) !!}

            </div>
        </div>

        {{--  Street 2 --}}
        <div class="col-xs-12 col-md-5">
            <div class="form-group">

                {!! Form::label('origin-address[street-2]', trans('manage_settings.shipment.origin-address.street-2.label'), ['class' => 'input-label']) !!}

                {{-- <small class="text__p text__p--description text__p--description-contact">{{ trans('manage_settings.shipment.origin-address.street-2.helper') }}</small> --}}

                {!! Form::text('origin-address[street-2]', array_get($setting_shipment,'origin-address.street-2'), [
                    'class'         => 'form-control input',
                    'form'          => 'update_setting-shipment_form',
                    'placeholder'   => trans('manage_settings.shipment.origin-address.street-2.placeholder'),
                    'required'      => 'required',
                ]) !!}

            </div>
        </div>

        {{--  Street 3 --}}
        <div class="col-xs-12 col-md-5 col-md-offset-1">
            <div class="form-group">

                {!! Form::label('origin-address[street-3]', trans('manage_settings.shipment.origin-address.street-3.label'), ['class' => 'input-label']) !!}

                {{-- <small class="text__p text__p--description text__p--description-contact">{{ trans('manage_settings.shipment.origin-address.street-3.helper') }}</small> --}}

                {!! Form::text('origin-address[street-3]', array_get($setting_shipment,'origin-address.street-3'), [
                    'class'         => 'form-control input',
                    'form'          => 'update_setting-shipment_form',
                    'placeholder'   => trans('manage_settings.shipment.origin-address.street-3.placeholder'),
                    'required'      => 'required',
                ]) !!}

            </div>
        </div>

        {{--  City --}}
        <div class="col-xs-12 col-md-5">
            <div class="form-group">

                {!! Form::label('origin-address[city]', trans('manage_settings.shipment.origin-address.city.label'), ['class' => 'input-label']) !!}

                {{-- <small class="text__p text__p--description text__p--description-contact">{{ trans('manage_settings.shipment.origin-address.city.helper') }}</small> --}}

                {!! Form::text('origin-address[city]', array_get($setting_shipment,'origin-address.city'), [
                    'class'         => 'form-control input',
                    'form'          => 'update_setting-shipment_form',
                    'placeholder'   => trans('manage_settings.shipment.origin-address.city.placeholder'),
                    'required'      => 'required',
                ]) !!}

            </div>
        </div>

        {{--  State --}}
        <div class="col-xs-12 col-md-5 col-md-offset-1">
            <div class="form-group">

                {!! Form::label('origin-address[state]', trans('manage_settings.shipment.origin-address.state.label'), ['class' => 'input-label']) !!}

                {{-- <small class="text__p text__p--description text__p--description-contact">{{ trans('manage_settings.shipment.origin-address.state.helper') }}</small> --}}

                {!! Form::text('origin-address[state]', array_get($setting_shipment,'origin-address.state'), [
                    'class'         => 'form-control input',
                    'form'          => 'update_setting-shipment_form',
                    'placeholder'   => trans('manage_settings.shipment.origin-address.state.placeholder'),
                    'required'      => 'required',
                ]) !!}

            </div>
        </div>

        {{--  Country --}}
        <div class="col-xs-12 col-md-5">
            <div class="form-group">

                {!! Form::label('origin-address[country]', trans('manage_settings.shipment.origin-address.country.label'), ['class' => 'input-label']) !!}

                {{-- <small class="text__p text__p--description text__p--description-contact">{{ trans('manage_settings.shipment.origin-address.country.helper') }}</small> --}}

                {!! Form::text('origin-address[country]', array_get($setting_shipment,'origin-address.country'), [
                    'class'         => 'form-control input',
                    'form'          => 'update_setting-shipment_form',
                    'placeholder'   => trans('manage_settings.shipment.origin-address.country.placeholder'),
                    'required'      => 'required',
                ]) !!}

            </div>
        </div>

        {{-- ZIP --}}
        <div class="col-xs-12 col-md-5 col-md-offset-1">
            <div class="form-group">

                {!! Form::label('origin-address[zip]', trans('manage_settings.shipment.origin-address.zip.label'), ['class' => 'input-label']) !!}

                {{-- <small class="text__p text__p--description text__p--description-contact">{{ trans('manage_settings.shipment.origin-address.zip.helper') }}</small> --}}

                {!! Form::text('origin-address[zip]', array_get($setting_shipment,'origin-address.zip'), [
                    'class'         => 'form-control input',
                    'form'          => 'update_setting-shipment_form',
                    'placeholder'   => trans('manage_settings.shipment.origin-address.zip.placeholder'),
                    'required'      => 'required',
                ]) !!}

            </div>
        </div>

    </div>

    {{-- <div class="row contact__row">

        <div class="col-xs-12 col-md-5 col-md-offset-1">
            <div class="form-group">

                {!! Form::label('minimal-clothing', trans('manage_settings.shipment.minimal-clothing.label'), ['class' => 'input-label']) !!}



                {!! Form::text('minimal-clothing', array_get($setting_shipment,'minimal-clothing'), [
                    'class'         => 'form-control input',
                    'form'          => 'update_setting-shipment_form',
                    'placeholder'   => trans('manage_settings.shipment.minimal-clothing.placeholder'),
                    'required'      => 'required',
                ]) !!}

            </div>
        </div>

        <div class="col-xs-12 col-md-5">
            <div class="form-group">

                {!! Form::label('average-weight', trans('manage_settings.shipment.average-weight.label'), ['class' => 'input-label']) !!}

                {!! Form::text('average-weight', array_get($setting_shipment,'average-weight'), [
                    'class'         => 'form-control input',
                    'form'          => 'update_setting-shipment_form',
                    'placeholder'   => trans('manage_settings.shipment.average-weight.label'),
                    'required'      => 'required',
                ]) !!}

            </div>
        </div>

    </div> --}}

    <br>

    <div class="row">
        <div class="col-xs-2 col-xs-offset-9">
            {!! Form::submit(trans('manage_settings.general.save'), ['class' => 'btn btn-info button input-sm']) !!}
        </div>
    </div>

{!! Form::close() !!}
