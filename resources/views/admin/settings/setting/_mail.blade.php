{!! Form::open([
      'method'              => 'PATCH',
      'action'              => ['Admin\Settings\ManageSettingController@update', 'mail'],
      'role'                => 'form' ,
      'id'                  => 'update_setting-mail_form',
    ]) !!}

    @include('admin.general._page-subtitle', ['title' => trans('manage_settings.mail.title') ])

    <div class="col-xs-12 col-md-10 col-md-offset-1">

        <div class="row contact__row">

            <div class="col-xs-12 col-md-6">

                <div class="form-group">

                    {!! Form::label('contact', trans('manage_settings.mail.contact.label'), ['class' => 'input-label']) !!}

                    {!! Form::text('contact', array_get($setting_mail,'contact'), [
                        'class'         => 'form-control input',
                        'form'          => 'update_setting-mail_form',
                        'placeholder'   => trans('manage_settings.mail.contact.placeholder'),
                        'required'      => 'required',
                    ]) !!}

                </div>

            </div>

            <div class="col-xs-12 col-md-6">

                <div class="form-group">

                    {!! Form::label('notifications', trans('manage_settings.mail.notifications.label'), ['class' => 'input-label']) !!}

                    {!! Form::text('notifications', array_get($setting_mail,'notifications'), [
                        'class'         => 'form-control input',
                        'form'          => 'update_setting-mail_form',
                        'placeholder'   => trans('manage_settings.mail.notifications.placeholder'),
                        'required'      => 'required',
                    ]) !!}

                </div>

            </div>

            <div class="col-xs-12 col-md-6">

                <div class="form-group">

                    {!! Form::label('system', trans('manage_settings.mail.system.label'), ['class' => 'input-label']) !!}

                    {!! Form::text('system', array_get($setting_mail,'system'), [
                        'class'         => 'form-control input',
                       'form'          => 'update_setting-mail_form',
                        'placeholder'   => trans('manage_settings.mail.system.placeholder'),
                        'required'      => 'required',
                    ]) !!}

                </div>

            </div>

        </div>

        <br>

        <div class="row">
            @foreach($languages as $lang)

            <div class="col-xs-12 col-md-6">
                <div class="form-group">
                    {!! Form::label('mail_greeting['.$lang->iso6391.']', trans('manage_settings.mail.mail_greeting.'.$lang->iso6391.'.label'), ['class' => 'input-label']) !!}
                    {!! Form::textarea('mail_greeting['.$lang->iso6391.']', clean_classes_and_inline_styles(array_get($setting_mail,'mail_greeting.'.$lang->iso6391)), [
                        'class' => 'form-control summernote_JS',
                    ]) !!}
                </div>
            </div>

            @endforeach

            @foreach($languages as $lang)

            <div class="col-xs-12 col-md-6">
                <div class="form-group">
                    {!! Form::label('mail_farewell['.$lang->iso6391.']', trans('manage_settings.mail.mail_farewell.'.$lang->iso6391.'.label'), ['class' => 'input-label']) !!}
                    {!! Form::textarea('mail_farewell['.$lang->iso6391.']', clean_classes_and_inline_styles(array_get($setting_mail,'mail_farewell.'.$lang->iso6391)), [
                        'class' => 'form-control summernote_JS',
                    ]) !!}
                </div>
            </div>

            @endforeach

            @foreach($languages as $lang)

            <div class="col-xs-12 col-md-6">
                <div class="form-group">
                    {!! Form::label('register_copy['.$lang->iso6391.']', trans('manage_settings.mail.register_copy.'.$lang->iso6391.'.label'), ['class' => 'input-label']) !!}
                    {!! Form::textarea('register_copy['.$lang->iso6391.']', clean_classes_and_inline_styles(array_get($setting_mail,'register_copy.'.$lang->iso6391)), [
                        'class' => 'form-control summernote_JS'
                        // summernote_JS',
                    ]) !!}
                </div>
            </div>

            @endforeach

            @foreach($languages as $lang)

            <div class="col-xs-12 col-md-6">
                <div class="form-group">
                    {!! Form::label('purchase_copy['.$lang->iso6391.']', trans('manage_settings.mail.purchase_copy.'.$lang->iso6391.'.label'), ['class' => 'input-label']) !!}
                    {!! Form::textarea('purchase_copy['.$lang->iso6391.']', clean_classes_and_inline_styles(array_get($setting_mail,'purchase_copy.'.$lang->iso6391)), [
                        'class' => 'form-control summernote_JS',
                        // summernote_JS
                    ]) !!}
                </div>
            </div>

            @endforeach

			@foreach($languages as $lang)

			<div class="col-xs-12 col-md-6">
				<div class="form-group">
					{!! Form::label('cash_out_copy['.$lang->iso6391.']', trans('manage_settings.mail.cash_out_copy.'.$lang->iso6391.'.label'), ['class' => 'input-label']) !!}
					{!! Form::textarea('cash_out_copy['.$lang->iso6391.']', clean_classes_and_inline_styles(array_get($setting_mail,'cash_out_copy.'.$lang->iso6391)), [
						'class' => 'form-control summernote_JS',
						// summernote_JS
					]) !!}
				</div>
			</div>

			@endforeach

            {{-- @foreach($languages as $lang)

            <div class="col-xs-12 col-md-6">
                <div class="form-group">
                    {!! Form::label('thanks_copy['.$lang->iso6391.']', trans('manage_settings.mail.thanks_copy.'.$lang->iso6391.'.label'), ['class' => 'input-label']) !!}
                    {!! Form::textarea('thanks_copy['.$lang->iso6391.']', array_get($setting_mail,'thanks_copy.'.$lang->iso6391), [
                        'class' => 'form-control summernote_JS',
                    ]) !!}
                </div>
            </div>

            @endforeach --}}
        </div>

    </div>

    <br>

    <div class="row">
        <div class="col-xs-2 col-xs-offset-9">
            {!! Form::submit('guardar', ['class' => 'btn btn-info button ']) !!}
        </div>
    </div>

{!! Form::close() !!}
