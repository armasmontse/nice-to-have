@extends('layouts.client',  ['body_id'	=> 	'single-vue'])

@section('title')
    | {{ ucfirst($product->slug) }}
@endsection

@section('content')

<div id="" class="single-product">

    @include('client.general.scroll-up-icon')

    <single-product
    	:is-event-shop='store.is_event_shop'
		:product="store.product.data"
		:current-language="store.current_language"
		:products-in-wishlist="store.products_in_wishlist"
		:bag-keys="store.bag_keys"
		:printable-bag-index-by-printable-bag-slug="printableBagIndexByPrintableBagSlug"
		:skus-by-printable-bag="skusByPrintableBag"
		v-if="store.product.data"
		>
	</single-product>

    <div v-else class="text-center mb40">
		@include('client.general.loading-icon')
	</div>

	<script type="x/templates" id="single-product-template">

        <div>

            @unless (is_page("client::events.shop.single"))
                <div class="grid__container single__container--breadcrumbs">
                    @include('client.shop.partials.breadcrumbs')
                </div>
            @endunless

            <single-product-info
					:variants="variants"
					:title="title"
					:main-description="description"
					:id="product.id"
					:in-wishlist="in_wishlist"
					:printable-bag-index-by-printable-bag-slug="printableBagIndexByPrintableBagSlug"
					:skus-by-printable-bag="skusByPrintableBag"
					:bag-keys="bagKeys"
					:is-single="true"
					:wishlist-link-as-button="true"
					>
			</single-product-info>

            <div class="grid__container single__container single__container--full-width single__container__reordering p0">

                <div class="single__col single__col-1-3--lg">
					<div class="single__box single__box--1-3--left">
						<div class="single__bg-img" :style="{ backgroundImage: photos['0'] ? 'url(' + photos['0'] +')' : '' }" :class="{'': !photos['0']	}"></div> <!--shop-product__no-image no-image single__no-image fa fa-eye-slash-->
					</div>
				</div>

				<div class="single__col single__col-1-3--sm">
					<div class="single__box single__box--1-3--center">
						<div class="single__bg-img" :style="{ backgroundImage: photos['1'] ? 'url(' + photos['1'] +')' : '' }" :class="{'': !photos['1']	}"></div> <!--shop-product__no-image no-image single__no-image fa fa-eye-slash-->
					</div>
				</div>

				<div class="single__col single__col-1-3--lg">
					<div class="single__box single__box--1-3--right">
						<div class="single__bg-img" :style="{ backgroundImage: photos['2'] ? 'url(' + photos['2'] +')' : '' }" :class="{'': !photos['2']	}"></div> <!--shop-product__no-image no-image single__no-image fa fa-eye-slash-->
					</div>
				</div>

				<div class="single__col single__col-3-4">
					<div class="single__box single__box--1-2--left">
						<div class="single__bg-img" :style="{ backgroundImage: photos['3'] ? 'url(' + photos['3'] +')' : '' }" :class="{'': !photos['3']	}"></div> <!--shop-product__no-image no-image single__no-image fa fa-eye-slash-->
					</div>
				</div>

				<div class="single__col single__col-1-4">
					<div class="single__box single__box--1-2--right">
						<div class="single__bg-img" :style="{ backgroundImage: photos['4'] ? 'url(' + photos['4'] +')' : '' }" :class="{'': !photos['4']	}"></div> <!--shop-product__no-image no-image single__no-image fa fa-eye-slash-->
					</div>
				</div>
				<div id="info-sections" class="w100">
					<info-section v-for="section in info_sections" :section="section" :class="{'single__col' : true}"></info-section>
				</div>
			</div>

			<div class="relatedProducts" v-if="relatedProducts.length > 0">
				<div class="grid__container relatedProducts__container">
					<div class="grid__col-1-1">
						<h3 class="relatedProducts__ttl">También te podrían gustar estos productos</h3>
					</div>
					<div class="swiper-container relatedProducts__slider">
					    <div class="swiper-wrapper relatedProducts__slider-wrapper">
						        <div class="swiper-slide relatedProducts__slider-slide" v-for="product in relatedProducts" data-swiper-autoplay="3000">
						        	<shop-product
						        		:name="product.name"
						        		:price="product.price"
						        		:link="isEventShop ? product.event_shop_url : product.client_url"
						        		:img_url="product.img_url"
		        						:is_published="product.is_published"
						        	></shop-product>
						        </div>
					    </div>
					</div>
					<div class="swiper-button-prev relatedProducts__slider-nav relatedProducts__slider-nav--prev fa fa-angle-left"></div>
					<div class="swiper-button-next relatedProducts__slider-nav relatedProducts__slider-nav--next fa fa-angle-right"></div>
				</div>
			</div>

		</div>

	</script>

</div>
@endsection


@section('vue_templates')
	@include('client.single.vue.single-product-info-template')
	@include('client.general.vue.info-section-template')
	@include('client.shop.vue.shop-product-template')
@endsection

@section('vue_store')
	<script>
		mainVueStore.product = mainVueStore.ajaxData({ get: '{{route('client::single.ajax.show', $product->slug)}}'})
		mainVueStore.is_event_shop = {!! json_encode($is_event_shop) !!};

	</script>
@endsection
