 @if ($user)
	{!! Form::open([
		'method' 				=> 'POST',
		'class' 				=> '',
		'route'                => ['user::wishlist.ajax.store', $user->name],
		'role'                  => 'form',
		'id'                    => 'addtowishlist_single-product_form',
		'v-on:submit.prevent'   => 'post',
		'v-if'					=> 	'!inWishlist'
	]) !!}

		{!! Form::hidden("favorite_id", '&#123;&#123;id&#125;&#125;', [
		   'required'	=> 'required',
		   'form'     	=> 'addtowishlist_single-product_form',
		]) !!}

		{!! Form::submit(trans("single.add_to_wishlist"), [
			':class' => '&#123;"single__link-button": !wishlistLinkAsButton, "input__submit": wishlistLinkAsButton&#125;',
			'form'	=> 'addtowishlist_single-product_form',
		]) !!}

{!! Form::close() !!}


{!! Form::open([
	'method' 				=> 'DELETE',
	'class' 				=> '',
	'route'                => ['user::wishlist.ajax.destroy', $user->name, '&#123;&#123;id&#125;&#125;'],
	'role'                  => 'form',
	'id'                    => 'removefromwishlist_product-&#123;&#123;id&#125;&#125;_form',
	'v-on:submit.prevent'   => 'post',
	'v-if'	=> 	'inWishlist'
]) !!}

		{!! Form::hidden("favorite_id", '&#123;&#123;id&#125;&#125;', [
		   'required'	=> 'required',
		   'form'     	=> 'removefromwishlist_product-&#123;&#123;id&#125;&#125;_form',
		]) !!}

		{!! Form::submit(trans("single.remove_from_wishlist"), [
			':class' => '&#123;"single__link-button": !wishlistLinkAsButton, "input__submit": wishlistLinkAsButton&#125;',
			'form'	=> 'removefromwishlist_product-&#123;&#123;id&#125;&#125;_form',
		]) !!}
{!! Form::close() !!}
@else
	<a href="{{ route("client::login:get") }}" :class='{"single__link-button": !wishlistLinkAsButton, "input__submit": wishlistLinkAsButton }'  >{{ trans("single.add_to_wishlist") }}</a>
@endif
