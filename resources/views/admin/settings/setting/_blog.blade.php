{!! Form::open([
      'method'              => 'PATCH',
      'action'              => ['Admin\Settings\ManageSettingController@update', 'blog'],
      'role'                => 'form' ,
      'id'                  => 'update_setting-blog_form',
    ]) !!}

    @include('admin.general._page-subtitle', ['title' => trans('manage_settings.blog.title') ])

    <div class="row contact__row">
        <div class="col-xs-12 col-md-5 col-md-offset-1">
            <div class="form-group">

                {!! Form::label('url', trans('manage_settings.blog.url.label'), ['class' => 'input-label']) !!}

                {!! Form::text('url', array_get($setting_blog,'url'), [
                    'class'         => 'form-control input',
                    'form'          => 'update_setting-blog_form',
                    'placeholder'   => trans('manage_settings.blog.url.placeholder')
                ]) !!}

                {{-- <small class="help-block">{{ trans('manage_settings.blog.url.helper') }}</small> --}}

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
