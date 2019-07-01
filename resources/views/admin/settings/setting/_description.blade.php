{!! Form::open([
      'method'              => 'PATCH',
      'action'              => ['Admin\Settings\ManageSettingController@update', 'description'],
      'role'                => 'form' ,
      'id'                  => 'update_setting-description_form',
    ]) !!}

    @include('admin.general._page-subtitle', ['title' => trans('manage_settings.description.title') ])

    @foreach($languages as $lang)

    <div class="col-xs-12 col-md-10 col-md-offset-1">
        <div class="form-group">
            {!! Form::label('description['.$lang->iso6391.']', trans('manage_settings.description.'.$lang->iso6391.'.label'), [
                'class' => 'input-label'
            ]) !!}
            {!! Form::textarea('description['.$lang->iso6391.']', clean_classes_and_inline_styles(array_get($setting_description->value,'description.'.$lang->iso6391)), [
                'class' => 'form-control',
            ]) !!}
        </div>
    </div>

    @endforeach

    <div class="row contact__row" style="margin-bottom: 2rem;">

           <div class="col-xs-10 col-xs-offset-1">

               <label class="input-label" for="">{{ trans('manage_settings.description.image-label') }}</label>

                <single-image
					v-ref:{{ $setting_description->key . '_thumbnail' }}
					:type="'product-photos'"
					:current-image="'{{ json_encode($setting_description->getFirstPhotoTo([ 'use' => 'thumbnail' ]))   }}'"
					:photoable-id="'{{ $setting_description->key }}'"
					:photoable-type="'{{ $setting_description->getPhotoableCode() }}'"
					:use="'thumbnail'"
					:class="''"
					:default-order="''"
				></single-image>

        </div>

    </div>


    <br>

    <div class="row">
        <div class="col-xs-2 col-xs-offset-9">
            {!! Form::submit(trans('manage_settings.general.save'), ['class' => 'btn btn-info button']) !!}
        </div>
    </div>

{!! Form::close() !!}
