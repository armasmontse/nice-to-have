<product-sections :list.sync="store.sections.data"></product-sections>
<script type="x/templates" id="product-sections-template">

    <div class="row">
        <div class="col-xs-12">
            <a class="link-as-button pull-right" href="#" data-toggle="modal" data-target="#product-section-create">Agregar sección</a>
        </div>

        <div class="col-xs-12" v-for = "product_section in list" >
            <div class="row ">
                <div class="col-xs-1 text-center text__p">
                    @{{ product_section.order }}
                </div>
                <div class="col-xs-9 text__p">

                    <strong>@{{ product_section.title }}</strong> <br>

                    <div class="text__p">
                        @{{{ product_section.br_content }}}
                    </div>

                </div>
                <div class="col-xs-2">
                    <div class="row text-center">
                        <div class="col-xs-6 ">
                            <a class="icon" href="#" data-toggle="modal" data-target="#product-section-edit" data-index="@{{$index}}">
                                <i class="fa fa-pencil" aria-hidden="true"></i>
                            </a>
                        </div>
                        <div class="col-xs-6">
                            {!! Form::open([
                                'method'             => 'delete',
                                'route'              => ['admin::products.secciones.ajax.destroy',$product_edit->id,"&#123;&#123;product_section.id&#125;&#125;"],
                                'role'               => 'form' ,
                                'id'                 => 'delete_product-section-&#123;&#123;product_section.id&#125;&#125;_form',
                                'class'              => 'form-inline',
                                'data-index'         => '&#123;&#123;$index&#125;&#125;',
                                'v-on:submit.prevent'   => 'post'
                            ]) !!}

                                <button type="submit" class="icon" form ="delete_product-section-@{{product_section.id}}_form">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </button>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>

                <div class="col-xs-12">
                    <hr>
                </div>
            </div>
        </div>
    </div>
</script>
