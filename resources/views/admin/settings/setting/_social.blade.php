{!! Form::open([
      'method'              => 'PATCH',
      'action'              => ['Admin\Settings\ManageSettingController@update', 'social'],
      'role'                => 'form' ,
      'id'                  => 'update_setting-social_form',
    ]) !!}

    @include('admin.general._page-subtitle', ['title' => trans('manage_settings.social.title') ])

    <div class="row contact__row">
        <div class="col-xs-10 col-md-5 col-md-offset-1">

            <div class="form-group">

                {!! Form::label('facebook', trans('manage_settings.social.facebook.label'), ['class' => 'input-label']) !!}

                {{-- <small class="text__p text__p--description text__p--description-contact">{{ trans('manage_settings.social.facebook.helper') }}</small> --}}

                {!! Form::text('facebook', array_get($setting_social,'facebook'), [
                    'class' => 'form-control input',
                    'form' => 'update_setting-social_form',
                    'placeholder' => trans('manage_settings.social.facebook.placeholder')
                ]) !!}

            </div>

            <div class="form-group">

                {!! Form::label('twitter', trans('manage_settings.social.twitter.label'), ['class' => 'input-label']) !!}

                {{-- <small class="text__p text__p--description text__p--description-contact">{{ trans('manage_settings.social.twitter.helper') }}</small> --}}

                {!! Form::text('twitter', array_get($setting_social,'twitter'), [
                    'class' => 'form-control input',
                    'form' => 'update_setting-social_form',
                    'placeholder' => trans('manage_settings.social.twitter.placeholder')
                ]) !!}

            </div>

        </div>
        <div class="col-xs-10 col-md-5">

            <div class="form-group">

                {!! Form::label('instagram', trans('manage_settings.social.instagram.label'), ['class' => 'input-label']) !!}

                {{-- <small class="text__p text__p--description text__p--description-contact">{{ trans('manage_settings.social.instagram.helper') }}</small> --}}

                {!! Form::text('instagram', array_get($setting_social,'instagram'), [
                    'class' => 'form-control input',
                    'form' => 'update_setting-social_form',
                    'placeholder' => trans('manage_settings.social.instagram.placeholder')
                ]) !!}

            </div>

            <div class="form-group">

                {!! Form::label('pinterest', trans('manage_settings.social.pinterest.label'), ['class' => 'input-label']) !!}

                {{-- <small class="text__p text__p--description text__p--description-contact">{{ trans('manage_settings.social.pinterest.helper') }}</small> --}}

                {!! Form::text('pinterest', array_get($setting_social,'pinterest'), [
                    'class' => 'form-control input',
                    'form' => 'update_setting-social_form',
                    'placeholder' => trans('manage_settings.social.pinterest.placeholder')
                ]) !!}

            </div>

        </div>
    </div>

    <br>

    <div class="row">
        <div class="col-xs-2 col-xs-offset-9">
            {!! Form::submit(trans('manage_settings.general.save'), ['class' => 'btn btn-info button ']) !!}
        </div>
    </div>


{!! Form::close() !!}
