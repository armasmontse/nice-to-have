<div class="saveForm">
    <div class="form-group">
        {!! Form::label("'status_".$section."'", 'Estado:', ['class' => 'saveForm__title']) !!}
        {!! Form::select("'status_".$section."'", array('activate' => 'Publicado','trash' => 'Borrador'),  null,[
            'class' => 'saveForm__input-select',
            'form' => "'save_".$section."_form'",
            ]) !!}
    </div>
    <div class="form-group">
        {!! Form::label("'date_".$section."'", 'Fecha de publicacion:', ['class' => 'saveForm__title']) !!}
        {!! Form::date('date_collection',date("Y-m-d"), [
            'class' => 'saveForm__input-select',
            'form' => "'save_".$section."_form'",
            ]) !!}
    </div>
    <div class="form-group">
        {!! Form::submit('GUARDAR', [
            'class' => 'saveForm__save-button',
            'form' => "'save_".$section."_form'"
            ]) !!}
    </div>
</div>
