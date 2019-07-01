<tr :class="{ info: sku.default }">
	<td>
		@{{sku.sku}}

		<div class="placeholders">
			@include('admin.media_manager.vue.vue-image')
		</div>

	</td>
	<td>
		<p>
			Precio <br>
			 @{{sku.price | parseMoney }}
		</p>
		<br>
		<p>
			Envío <br>
			@{{sku.local_shipping_rate | parseMoney }} / @{{sku.national_shipping_rate | parseMoney }}
		</p>
		<br>
		<p>
			Descuento <br>
			@{{ sku.discount | parsePercentage }}
		</p>
	</td>
	<td>
		<p>
			@{{ sku.description }}
		</p>
	</td>
	<td class="text-center" >
		<a class="icon" href="#" data-toggle="modal" data-target="#sku-edit" data-index="@{{index}}">
			<i class="fa fa-pencil" aria-hidden="true"></i>
		</a>

	</td>
	<td class="text-center" >
		{!! Form::open([
			'method'             => 'delete',
			'route'              => ['admin::products.skus.ajax.destroy',$product_edit->id,'&#123;&#123;sku.sku&#125;&#125;'],
			'role'               => 'form' ,
			'id'                 => 'delete_sku-&#123;&#123;sku.sku&#125;&#125;_form',
			'class'              => 'form-inline',
			'data-index'         => '&#123;&#123;index&#125;&#125;',
			'v-on:submit.prevent'   => 'post'
		]) !!}

			<button type="submit" class="icon" form ="delete_sku-@{{sku.sku}}_form">
				<i class="fa fa-trash" aria-hidden="true"></i>
			</button>
		{{ Form::close() }}
	</td>
</tr>
