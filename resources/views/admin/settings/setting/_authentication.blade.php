{!! Form::open([
      'method'              => 'PATCH',
      'action'              => ['Admin\Settings\ManageSettingController@update', 'authentication'],
      'role'                => 'form' ,
      'id'                  => 'update_setting-authentication_form',
      'class'               => 'row',
]) !!}

    @include('admin.general._page-subtitle', ['title' => trans('manage_settings.authentication.title') ])

    <div class="col-xs-10 col-xs-offset-1">
        <div class="row">

            <div class="col-xs-10">
                <h3 class="text__subtitle">{{ trans('manage_settings.authentication.copys') }}</h3>
            </div>

            @foreach($languages as $lang)
                <div class="col-xs-12 col-md-6">
                    <div class="form-group">
                        {!! Form::label('login[' . $lang->iso6391 . ']', trans('manage_settings.authentication.login'), ['class' => 'input-label']) !!}
                        {!! Form::textarea('login[' . $lang->iso6391 . ']', clean_classes_and_inline_styles(array_get($setting_authentication, 'login.' . $lang->iso6391)), [
                            'class' => 'form-control summernote_JS'
                        ]) !!}
                    </div>
                </div>
            @endforeach

            @foreach($languages as $lang)
                <div class="col-xs-12 col-md-6">
                    <div class="form-group">
                        {!! Form::label('main_register[' . $lang->iso6391 . ']', trans('manage_settings.authentication.main_register'), ['class' => 'input-label']) !!}
                        {!! Form::textarea('main_register[' . $lang->iso6391 . ']', clean_classes_and_inline_styles(array_get($setting_authentication, 'main_register.' . $lang->iso6391)), [
                            'class' => 'form-control summernote_JS'
                        ]) !!}
                    </div>
                </div>
            @endforeach

            @foreach($languages as $lang)
                <div class="col-xs-12 col-md-6">
                    <div class="form-group">
                        {!! Form::label('event_register[' . $lang->iso6391 . ']', trans('manage_settings.authentication.event_register'), ['class' => 'input-label']) !!}
                        {!! Form::textarea('event_register[' . $lang->iso6391 . ']', clean_classes_and_inline_styles(array_get($setting_authentication, 'event_register.' . $lang->iso6391)), [
                            'class' => 'form-control summernote_JS'
                        ]) !!}
                    </div>
                </div>
            @endforeach

            @foreach($languages as $lang)
                <div class="col-xs-12 col-md-6">
                    <div class="form-group">
                        {!! Form::label('checkout_register[' . $lang->iso6391 . ']', trans('manage_settings.authentication.checkout_register'), ['class' => 'input-label']) !!}
                        {!! Form::textarea('checkout_register[' . $lang->iso6391 . ']', clean_classes_and_inline_styles(array_get($setting_authentication, 'checkout_register.' . $lang->iso6391)), [
                            'class' => 'form-control summernote_JS'
                        ]) !!}
                    </div>
                </div>
            @endforeach

        </div>
    </div>
    <div class="col-xs-2 col-xs-offset-9">
        {!! Form::submit('guardar', ['class' => 'btn btn-info button']) !!}
    </div>
{!! Form::close() !!}

<div class="row contact__row">
	<div class="col-xs-10 col-xs-offset-1">
		<br>    <br>
	</div>
	<div class="col-xs-10 col-xs-offset-1">
		<div class="row">
			<div class=" col-xs-6 ">
				<h3 class="text__subtitle">{{ trans('manage_settings.authentication.login_image') }}</h3>

				<single-image
					v-ref:{{ $setting_login_image->key . '_thumbnail' }}
					:type="'product-photos'"
					:current-image="'{{ json_encode($setting_login_image->getFirstPhotoTo( [ 'use' => 'thumbnail' ] ))   }}'"
					:photoable-id="'{{ $setting_login_image->key }}'"
					:photoable-type="'{{ $setting_login_image->getPhotoableCode() }}'"
					:use="'thumbnail'"
					:class="''"
					:default-order="''"
				>
				</single-image>

			</div>

			<div class="col-xs-6">
				<h3 class="text__subtitle">{{ trans('manage_settings.authentication.register_image') }}</h3>

				<single-image
					v-ref:{{ $setting_register_image->key . '_thumbnail' }}
					:type="'product-photos'"
					:current-image="'{{ json_encode($setting_register_image->getFirstPhotoTo( [ 'use' => 'thumbnail' ] ))   }}'"
					:photoable-id="'{{ $setting_register_image->key }}'"
					:photoable-type="'{{ $setting_register_image->getPhotoableCode() }}'"
					:use="'thumbnail'"
					:class="''"
					:default-order="''"
				>
				</single-image>

			</div>


			<div class="col-xs-6">
				<h3 class="text__subtitle">{{ trans('manage_settings.authentication.event_register_image') }}</h3>
				<single-image
					v-ref:{{ $setting_event_register_image->key . '_thumbnail' }}
					:type="'product-photos'"
					:current-image="'{{ json_encode($setting_event_register_image->getFirstPhotoTo( [ 'use' => 'thumbnail' ] ))   }}'"
					:photoable-id="'{{ $setting_event_register_image->key }}'"
					:photoable-type="'{{ $setting_event_register_image->getPhotoableCode() }}'"
					:use="'thumbnail'"
					:class="''"
					:default-order="''"
				>
				</single-image>

			</div>


			<div class="col-xs-6">
				<h3 class="text__subtitle">{{ trans('manage_settings.authentication.checkout_register_image') }}</h3>

				<single-image
					v-ref:{{ $setting_checkout_register_image->key . '_thumbnail' }}
					:type="'product-photos'"
					:current-image="'{{ json_encode($setting_checkout_register_image->getFirstPhotoTo( [ 'use' => 'thumbnail' ] ))   }}'"
					:photoable-id="'{{ $setting_checkout_register_image->key }}'"
					:photoable-type="'{{ $setting_checkout_register_image->getPhotoableCode() }}'"
					:use="'thumbnail'"
					:class="''"
					:default-order="''"
				>
				</single-image>

			</div>
		</div>
	</div>
</div>
