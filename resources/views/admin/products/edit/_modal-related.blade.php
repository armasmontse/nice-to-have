@extends('layouts.modal',["modal_id"=> "related-products-modal-create"])

@section('modal-title')
    Relacionar un producto
@overwrite

@section('modal-content')
<related-products-modal-create
    :list="store.products.data"
    :related-products.sync="store.related_products_ids"
    :selected-elems="store.current_product.data.products_related"></related-products-modal-create>
<script type="x/templates"  id="related-products-modal-create-template">
    <div>
    	<div v-if="list.length === 0" class="text-center">
	    	<h2 class="loading-text">Cargando productos...</h2>
    		@include('client.general.loading-icon')
    	</div>
    	<div v-else>
    	{!! Form::open([
    			'method'                => 'patch',
    			'route'                 => ['admin::products.related-products.ajax.update',$product_edit->id],
    			'role'                  => 'form' ,
    			'id'                    => 'updaterelatedproducts_form',
    			'class'                 => 'row',
                'v-on:submit.prevent'   => 'post',
    		]) !!}

            <div class="col-xs-4">
                <div class="form-group">
    	    		<input type="text" placeholder="Buscar un producto" v-model="search" class="form-control input">
        		</div>
            </div>

            <div class="col-xs-8">
                <button type="submit" from="updaterelatedproducts_form" class="btn btn-info button pull-right">Guardar</button>
            </div>

            <div class="col-xs-12">
                <div class="form-group" v-for="product in filterable_elems">
                    <label :for="product.title + $index" class="input__checkbox-label">
                        {{-- Estos inputs no se mandan, pues al ser fitlrados, los checkboxes selccionadas no se mandarían --}}
                        <input type="checkbox"
                            from="update_associate-updaterelatedproducts_form"
                            :id="product.title + $index"
                            :value="product.id + ''"
                            v-model="selected_checkboxes"
                            class="input__checkbox"
                            >
                        @{{product.title}}
                    </label>
                </div>
            </div>
        {{-- Estos inputs sí se mandan, ver el v-for --}}
            <input type="hidden"
                v-for="value in selected_checkboxes"
                name="products[@{{value}}]'"
                :value="value"
            >
    	{!! Form::close() !!}
    	</div>
    </div>
</script>
@overwrite
