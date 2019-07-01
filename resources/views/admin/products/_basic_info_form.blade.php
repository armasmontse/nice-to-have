{!! Form::open([
    'method'             => $form_method,
    'route'              => $form_route,
    'role'               => 'form' ,
    'id'                 => $form_id,
    'class'              => 'row',
    ]) !!}

<div class="col-xs-10 col-xs-offset-1">

    <div class="row">

        <div class="col-xs-3  col-xs-offset-6">
            <div class="form-group">
                {!! Form::label('publish_date', "Fecha de publicación:", ['class' => 'input-label']) !!}
                {!! Form::date('publish_date', $product_edit->publish_at ? $product_edit->publish_at->format("Y-m-d") : null, [
                    'class'         => 'form-control input',
                    'required'      => 'required',
                    'placeholder'   => date("Y-m-d"),
                    'form'          => $form_id,
                    'id'            => 'publish_date'
                ])  !!}
            </div>
        </div>

        <div class="col-xs-3">
            <div class="form-group">
                {!! Form::label('publish_id', "Estado:", ['class' => 'input-label']) !!}
                <div class="input__select-container">
                    {!! Form::select('publish_id', $publiches_list, $product_edit->publish_id , [
                        'class'         => 'form-control input__select',
                        'required'      => 'required',
                        'placeholder'   => "Seleccionar",
                        'form'          => $form_id,
                        "id"            => "publish_id"
                    ])  !!}
                    <span class="fa fa-angle-down input__select-arrow" aria-hidden="true"></span>
                </div>
            </div>
        </div>

    </div>

    <div class="row">

        @foreach ($languages as $language)
            <div class="col-xs-12">
                <div class="form-group">
                    {!! Form::label("title[".$language->iso6391."]", "Nombre:", ['class' => 'input-label']) !!}
                    {!! Form::text("title[".$language->iso6391."]", $product_edit->id ?  $product_edit->translation($language->iso6391)->title :null, [
                        'class'         => 'form-control input',
                        'required'      => 'required',
                        'form'          => $form_id,
                        'placeholder'   =>  "Agregar nombre del producto"
                        ]) !!}
                </div>
                <div class="form-group">
                    {!! Form::label("description[".$language->iso6391."]", "Descripción", ['class' => 'input-label']) !!}
                    {!! Form::textarea("description[".$language->iso6391."]", $product_edit->id ?  $product_edit->translation($language->iso6391)->description :null, [
                        'class'         => 'form-control input',
                        // 'required'      => 'required',
                        'form'          => $form_id,
                        "rows"          => 3,
                        'placeholder'   =>  "Agregar detalles del producto"
                        ]) !!}
                </div>
            </div>
        @endforeach

    </div>

    <div class="row ">

        <providers-select :list="store.providers.data" :current-product="store.current_product.data" ></providers-select>

        <script type="x/templates" id="providers-select-template">
            <div class="col-xs-6 ">
                <div class="form-group">
                    {!! Form::label('provider_id', "Proveedor", ['class' => 'input-label']) !!}
                    <div class="input__select-container">
                        <select class="form-control input__select"
                                required="required"
                                form="{{$form_id}}"
                                name="provider_id"
                                id="provider_id"
                                v-model="currentProduct.provider_id"
                                >
                            <option value="" disabled="disabled" >Seleccionar</option>
                            <option :value="provider.id" v-for="provider in list">&#123;&#123; provider.label&#125;&#125;</option>
                        </select>
                        <span class="fa fa-angle-down input__select-arrow" aria-hidden="true"></span>
                    </div>
                    <a class="link-underline" href="#" data-toggle="modal" data-target="#provider-create">(Agregar un proveedor)</a>
                </div>
            </div>
        </script>

        <div class="col-xs-3 col-xs-offset-3 button__col">
            <div class="btn-group pull-right">
                {!! Form::submit($form_submit, [
                    'class' => 'btn btn-info button',
                    'form'  => $form_id
                ]) !!}
            </div>
        </div>

    </div>

</div>

{!! Form::close() !!}
