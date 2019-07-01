		{{-- Modal agregar --}}
		<div class="modal__overlay"
			v-if="modal_is_open"
			@click.stop="closeModal"
		>
			<div class="modal__container" @click.stop="">
				<span class="modal__close" @click="closeModal">{!! file_get_contents('images/icon-close.svg') !!}</span>
				<div class="modal__container-scrollable">
					<p class="modal__message"  v-if="selected_quantity === 1">Se ha agregado 1 producto al carrito</p>
					<p class="modal__message"  v-else>Se han agregado @{{selected_quantity}} productos al carrito</p>

					<div class="grid__container modal__product-info-container">
						<div class="modal__col-1-2 modal__col-1-2--sm">
							<img :src="selected_variant.image_url" alt="" class="modal__product-img">
						</div>
						<div class="modal__col-1-2 modal__col-1-2--lg">
							<div class="single__info-box">
								<h2 class="single__ttl">@{{title}}</h2>
								<p class="single__price">@{{selected_variant.price | parseMoney}}</p>
								<p class="single__description single__description--popup">@{{{mainDescription}}}</p>
								<p class="single__description single__description--popup">VARIACIÓN: <br>@{{selected_variant_index}}. @{{selected_variant.description}}</p>
							</div>
					</div>
					</div>
					<div class="modal__actions-container">
						<a href="{{route('client::bags.index')}}" class="input__submit">Ir al carrito</a>
						<a href="{{ is_page("client::events.shop.single") ?  $cookie_event->shop_url : route('client::shop.index') }}" class="input__submit" >Seguir Comprando</a>
					</div>
				</div>
			</div>
		</div>
{{-- Modal eliminar --}}
		<div class="modal__overlay"
			v-if="remove_modal_is_open"
			@click.stop="closeRemoveModal"
		>
			<div class="modal__container modal__container--sm" @click.stop="">
				<span class="modal__close" @click="closeRemoveModal">{!! file_get_contents('images/icon-close.svg') !!}</span>
				<div class="modal__container-scrollable">
					<div class="modal__message">{!! $shopping_carts_delete_product_copy !!}</div>
					<div class="modal__actions-container">
						<span class="input__submit" @click="removeItem">Eliminar</span>
						<span class="input__submit" @click="closeRemoveModal">Cancelar</span>
					</div>
				</div>
			</div>
		</div>
