<div class="row product__row-checkbox">
    <div class="col-xs-12">
        <a class="link-as-button" href="#" data-toggle="modal" data-target="#{{$kind_singular}}-create">Agregar {{$kind_singular_translated}}</a>
    </div>

    <div class="col-xs-12">
        <{{$kind_plural}}-checkboxes
            :list="store.{{$kind_plural}}.data"
            :selected-elems="store.current_product.data.{{$kind_plural}}"
        ></{{$kind_plural}}-checkboxes>
        <script type="x/templates"  id="{{$kind_plural}}-checkboxes-template">
            <div class="row">
                {!! Form::open([
                    'method'                => 'patch',
                    'route'                => ['admin::products.'.$kind_plural.'.ajax.update',$product_edit->id,'&#123;&#123;'.$kind_singular.'.id&#125;&#125;'],
                    'role'                  => 'form' ,
                    'id'                    => 'update_product-'.$kind_singular.'-&#123;&#123;'.$kind_singular.'.id&#125;&#125;_form',
                    'class'                 => 'col-xs-6',
                    'v-for'    =>     $kind_singular.' in list'
                ]) !!}
                    <div class="form-group">
                        <label for="{{$kind_singular}}_&#123;&#123;{{$kind_singular}}.id&#125;&#125;" class="input__checkbox-label">
                            {!! Form::checkbox($kind_plural.'[&#123;&#123;'.$kind_singular.'.id&#125;&#125;]', '&#123;&#123;'.$kind_singular.'.id&#125;&#125;', null, [
                                'class'     => 'input__checkbox',
                                'id'      => $kind_singular.'_&#123;&#123;'.$kind_singular.'.id&#125;&#125;',
                                'form'      => 'update_product-'.$kind_singular.'-&#123;&#123;'.$kind_singular.'.id&#125;&#125;_form',
                                'value'      => '&#123;&#123;'.$kind_singular.'.id&#125;&#125;',
                                'v-model'    =>  'selected_checkboxes',
                                'v-on:change'   => 'makePost',
                                ]) !!}

                            <strong>&#123;&#123;{{$kind_singular}}.{{$parent_singular}}_label&#125;&#125;: </strong>
                            &#123;&#123;{{$kind_singular}}.label&#125;&#125;
                        </label>
                    </div>
                {!!Form::close()!!}
            </div>
        </script>
    </div>

</div>
