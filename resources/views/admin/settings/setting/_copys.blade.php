{!! Form::open([
      'method'              => 'PATCH',
      'action'              => ['Admin\Settings\ManageSettingController@update', 'copys'],
      'role'                => 'form' ,
      'id'                  => 'update_setting-copys_form',
      'class'               => 'row',
]) !!}

    @include('admin.general._page-subtitle', ['title' => trans('manage_settings.copys.title') ])

    @foreach ($site_copys_by_page as $page => $copies)
        <div class="col-xs-10 col-xs-offset-1">
            <h4 class="text__subtitle">{{ trans('manage_settings.copys.' . $page . '.title') }}</h4>
        </div>

		<div class="col-xs-10 col-xs-offset-1">
			<div class="row">
		        @foreach ($copies as $copy)
					@foreach($languages as $lang)
		                <div class="col-xs-12 col-md-6">
		                    <div class="form-group">
		                        {!! Form::label($page . '_' . $copy . '[' . $lang->iso6391 . ']', trans('manage_settings.copys.' . $page . '.' . $copy), ['class' => 'input-label']) !!}
		                        {!! Form::textarea($page . '_' . $copy . '[' . $lang->iso6391 . ']', clean_classes_and_inline_styles(array_get($setting_copys, $page . '_' . $copy . '.' . $lang->iso6391)), [
		                            'class' => 'form-control summernote_JS'
		                        ]) !!}
		                    </div>
		                </div>
		            @endforeach
	        	@endforeach
			</div>
		</div>

		<br>

		<div class="col-xs-2 col-xs-offset-9">
			{!! Form::submit('guardar', ['class' => 'btn btn-info button']) !!}
		</div>
    @endforeach

{!! Form::close() !!}
