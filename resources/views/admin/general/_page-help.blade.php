<div class="row pages__row">
    <div class="col-xs-2 col-xs-offset-7">
        {!! Form::submit('guardar', ['class' => 'btn btn-primary button input-sm']) !!}
    </div>
</div>

<div class="row">
    <div class="col-xs-4 col-xs-offset-1">
        <div class="form-group">
            {!! Form::label('inputname', $title, ['class' => 'text__p']) !!}
            {!! Form::textarea('inputname', null, [
                'class' => 'form-control summernote_JS',
                'required' => 'required'
            ]) !!}
        </div>
    </div>

    <div class="col-xs-4">
        <p class="text__p">{{$image_title}}</p>
        <div style="height: 153px; margin-top: 5px; background-color: #BCBEC0;"></div>
        <small class="text__p text__p--description">{{$image_caption}}</small>
    </div>
</div>
