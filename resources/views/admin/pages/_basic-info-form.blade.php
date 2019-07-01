{!! Form::open([
    'method'             => $form_method,
    'route'              => $form_route,
    'role'               => 'form' ,
    'id'                 => $form_id,
    'class'              => 'col s10  offset s1',
    ]) !!}
    <div class="row row-mt">

        <div class=" col-md-10 col-md-offset-1">

            @if ($user->hasPermission("manage_pages"))
                {!! Form::label('index', "Identificador de la página:", [
                    'class' => 'active input-label',
                    ]) !!}
                {!! Form::text('index', $page_edit->index, [
                    'class'         => 'validate form-control input',
                    'required'      => 'required',
                    'form'          => $form_id,
                    'placeholder'   =>  "Home"
                ]) !!}
            @else
                <p class="text__p text__p--instructions"><strong>{{ $page_edit->index }}</strong></p>
            @endif

        </div>
    </div>
    <div class="row row-mt">
        <div class=" col-md-4 col-md-offset-1">
             {!! Form::label('publish_at', "Fecha de publicación:", [
                'class' => 'input-label active admin-label'
            ]) !!}
            {!! Form::date('publish_at', $page_edit->publish_at ? $page_edit->publish_at->format("Y-m-d") : date("Y-m-d"), [
                'class'         => 'validate  datepicker form-control input create-event__input--transparent',
                'required'      => 'required',
                'placeholder'   => date("Y-m-d"),
                'form'          => $form_id,
                "id"            => "publish_at"
            ])  !!}
        </div>

        <div class=" col-md-4 col-md-offset-1">
            {!! Form::label('publish_id', "Estatus de publicación:", [
                'class' => 'input-label active admin-label '
            ]) !!}
            <div class="input__select-container">
                {!! Form::select('publish_id', $publishes_list, $page_edit->publish_id, [
                    'class'         => 'form-control input__select',
                    'required'      => 'required',
                    'form'          => $form_id
                ])  !!}
                <span class="fa fa-angle-down input__select-arrow" aria-hidden="true"></span>
            </div>
        </div>
    </div>

    <div class="row row-mt">
        @unless ($page_edit->main)
            <div class=" col-md-7 col-md-offset-1">
                @if ($page_edit->childs->isEmpty())
                     {!! Form::label('parent_id', "Página padre", [
                        'class' => 'input-label active admin-label '
                    ]) !!}
                    <div class="input__select-container">
                        {!! Form::select('parent_id', $pages_list, $page_edit->parent_id, [
                            'class'         => 'validate form-control input__select',
                            'placeholder'   => "Seleccionar",
                            'form'          => $form_id
                        ])  !!}
                        <span class="fa fa-angle-down input__select-arrow" aria-hidden="true"></span>
                   </div>
                @endif
            </div>
            <div class="col-md-3">
                <div class="pull-right">
                    <label for="" class="switch-label">
                        ¿Abrir en nueva ventana?
                    </label>
                    <div class=" switch ">
                        <label>
                          {!! Form::checkbox("tblank", true , $page_edit->tblank, [
                                'class'     => 'input__checkbox',
                                'form'      => $form_id,
                                'data-toggle' => 'toggle',
                                'data-on'   => 'Si',
                                'data-off'  => 'No',
                                'data-onstyle' => 'default'
                            ]) !!} 
                            <span class="lever"></span>
                        </label>
                    </div>
                   <!--  <input type="checkbox" data-toggle="toggle" data-on="Si" data-off="No" data-onstyle="success"> -->
                </div>
            </div>
        @endunless
    </div>

    <div class="row row-mt">
        <div class="col-md-10 col-md-offset-1">

            @foreach($languages as $lang)
                <div class=" ">
                    {!! Form::label('label_'.$lang->iso6391, "Nombre la página: (".$lang->label.")", [
                        'class' => 'active input-label',
                        ]) !!}
                    {!! Form::text('label['.$lang->iso6391.']', $page_edit->id ? $page_edit->translation($lang->iso6391)->label : null, [
                        'class'         => 'validate form-control input',
                        'required'      => 'required',
                        'form'          => $form_id,
                        'placeholder'   =>  "Home",
                        'id'            => 'label_'.$lang->iso6391

                    ]) !!}
                </div>
            @endforeach
        </div>
    </div>
    <div class="row row-mt">
        <div class="col-md-10 col-md-offset-1">
            <div class="pull-right">
                {!! Form::submit("Guardar", [
                    'class' => 'btn btn-info button',
                    'form'  => $form_id
                ]) !!}
            </div>
        </div>
    </div>
{!! Form::close() !!}
