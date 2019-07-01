 {{-- Add to Bag --}}
{!! Form::open([
	'method' 				=> 'POST',
	'class' 				=> '',
	'route'                => ['client::bag.ajax.store', "&#123;&#123;bagKeys&#x5b;&#x27;".$bag_slug."&#x27;&#x5d;&#125;&#125;"],
	'role'                  => 'form',
	'id'                    => 'addtobag-'.$bag_slug.'-&#123;&#123; selected_variant.sku &#125;&#125;_form',
	'v-if'					=> "!inBag(selected_variant.sku, &#x27;".$bag_slug."&#x27;) ",
	'v-on:submit.prevent'   => 'post'
	//'v-else'	=> 	''
]) !!}

	{!! Form::hidden("sku", null, [
	   'required' 			=> 'required',
	   'form'     			=> 'addtobag-'.$bag_slug.'-&#123;&#123;selected_variant.sku&#125;&#125;_form',
	   'v-model' 			=> 'selected_variant.sku'
	]) !!}

	{!! Form::hidden("quantity", null, [
	   'required' 			=> 'required',
	   'form'     			=> 'addtobag-'.$bag_slug.'-&#123;&#123;selected_variant.sku&#125;&#125;_form',
	   'name'				=> 'quantity',
	   'v-model' 			=> 'selected_quantity'
	]) !!}

	<div class="relative">
		<input :disabled="disableSubmit"
			form="addtobag-{{$bag_slug}}-@{{selected_variant.sku}}_form"
			class="input__submit single__submit" type="submit" value="Agregar al carrito"
			@click="waiting_for_server = true"
		>
			<span v-if="waiting_for_server === false"
					class="input__submit-icon single__submit-icon">+
			</span>
			<span v-else
					class="input__submit-icon single__submit-icon">
					@include('client.general.loading-icon')
			</span>
	</div>
{!! Form::close() !!}

{{-- Update Bag --}}
{!! Form::open([
	'method'                => 'PATCH',

	'class'                 => '',
	'route'                => ['client::bag.ajax.update', "&#123;&#123;bagKeys&#x5b;&#x27;".$bag_slug."&#x27;&#x5d;&#125;&#125;", '&#123;&#123;selected_variant.sku&#125;&#125;'],
	'role'                  => 'form',
	'id'                    => 'updatebag-'.$bag_slug.'-&#123;&#123;selected_variant.sku&#125;&#125;_form',
	'v-if'                  => "inBag(selected_variant.sku, &#x27;".$bag_slug."&#x27;) &&
								!isSingle &&
								selected_quantity != quantity",
	'v-on:submit.prevent'   => 'post'
]) !!}

	{!! Form::hidden("quantity", null, [
	   'required'           => 'required',
	   'form'               => 'updatebag-'.$bag_slug.'-&#123;&#123;selected_variant.sku&#125;&#125;_form',
	   'name'               => 'quantity',
	   'v-model'            => 'selected_quantity'
	]) !!}

			<div class="relative" style="visibility: hidden; height: 0;width: 0;">
					<input :disabled="disableSubmit"
						form="updatebag-{{$bag_slug}}-@{{selected_variant.sku}}_form"
						class="input__submit single__submit" type="submit" value="{{trans('single.'.$bag_slug.'.update_bag')}}"
						@click="waiting_for_server = true"
						>
					<span  v-if="waiting_for_server === false"
							   class="input__submit-icon single__submit-icon">
							   +
					</span>
					<span v-else class="input__submit-icon single__submit-icon">
							@include('client.general.loading-icon')
					</span>
			</div>

{!! Form::close() !!}

{{-- Remove from Bag --}}
{!! Form::open([
	'method'                => 'DELETE',

	'class' 				=> '',
	'route'                => ['client::bag.ajax.destroy', "&#123;&#123;bagKeys&#x5b;&#x27;".$bag_slug."&#x27;&#x5d;&#125;&#125;", '&#123;&#123;selected_variant.sku&#125;&#125;'],
	'role'                  => 'form',
	'id'                    => 'removefrombag-'.$bag_slug.'-&#123;&#123;selected_variant.sku&#125;&#125;_form',
	'v-if'			=> "(isSingle && inBag(selected_variant.sku, &#x27;".$bag_slug."&#x27;)) ||
								(&#x27;".$bag_slug."&#x27; === bagSlug && !isWishlist)
								",//no usamos equivalencia estricta entre select_quantity y quantity porque el tipo puede cambiar entre Int y String
	'v-on:submit.prevent'   => 'post'
	]) !!}

	<div class="relative">
		<span :disabled="disableSubmit"
			@click.stop="openRemoveModal('removefrombag-{{$bag_slug}}-'+selected_variant.sku+'_form')"
			style="position: relative; top: 1px;"
			v-bind:class='{
				"input__submit single__submit" : !isShoppingBag,
				"single__link-button" : isShoppingBag
			}'
		>Eliminar del carrito</span>
		<span  v-if="waiting_for_server === false"
					class="input__submit-icon single__submit-icon">
			–
		</span>
		<span v-else class="input__submit-icon single__submit-icon  single__submit-icon--loader">
				@include('client.general.loading-icon')
		</span>
	</div>
{!! Form::close() !!}
