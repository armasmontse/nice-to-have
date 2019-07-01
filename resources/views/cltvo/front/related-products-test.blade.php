@extends('layouts.client', ['body_id'	=> 	'shop-vue'])

@section('content')
{{-- <div> --}}
{{-- 	<div class="grid__container single__container--breadcrumbs">
			@include('client.shop.partials.breadcrumbs')
	</div>			
	<single-product-info 
			:variants="variants" 
			:title="product.title" 
			:main-description="product.description">	
	</single-product-info>
	<div class="grid__container single__container single__container--full-width single__container__reordering p0">
		<div class="single__col single__col-1-3--lg">
			<div class="single__box single__box--1-3--left">
				<div class="single__bg-img" :style="{ backgroundImage: 'url(' + photos[0] +')' }"></div>
			</div>
		</div>
		<div class="single__col single__col-1-3--sm">
			<div class="single__box single__box--1-3--center">
				<div class="single__bg-img" :style="{ backgroundImage: 'url(' + photos[1] +')' }"></div>
			</div>
		</div>
		<div class="single__col single__col-1-3--lg">
			<div class="single__box single__box--1-3--right">
				<div class="single__bg-img" :style="{ backgroundImage: 'url(' + photos[2] +')' }"></div>
			</div>
		</div>
		<div class="single__col single__col-3-4">
			<div class="single__box single__box--1-2--left">
				<div class="single__bg-img" :style="{ backgroundImage: 'url(' + photos[3] +')' }"></div>
			</div>
		</div>
		<div class="single__col single__col-1-4">
			<div class="single__box single__box--1-2--right">
				<div class="single__bg-img" :style="{ backgroundImage: 'url(' + photos[4] +')' }"></div>
			</div>
		</div>
		<info-section v-for="section in info_sections" :section="section" :class="{'single__col' : true}"></info-section>
			
	</div> --}}
{{-- <div class="relatedProducts">
	<div class="grid__container relatedProducts__container">
		<div class="grid__col-1-1">
			<h3 class="relatedProducts__ttl">También te podrían gustar estos productos</h3>
		</div>
		<div class="swiper-container relatedProducts__slider">
		    <div class="swiper-wrapper relatedProducts__slider-wrapper">
			        <div class="swiper-slide relatedProducts__slider-slide" track-by="$index" v-for="product in ['','','','','']">
			        	<shop-product 
			        		:name="product.title"
			        		:price="product.price"
			        		:link="product.link"
			        		:link="product.link"
			        		:img_url="'http://localhost:3000/storage/images/fcfbe6247dc040368ae8b1d01c65a0f6.jpeg'"
			        	></shop-product>
			        </div>
		    </div>
		</div>
		<div class="swiper-button-prev relatedProducts__slider-nav relatedProducts__slider-nav--prev fa fa-angle-left"></div>
		<div class="swiper-button-next relatedProducts__slider-nav relatedProducts__slider-nav--next fa fa-angle-right"></div>
	</div>
</div> --}}
{{-- </div> --}}
@endsection

@section('vue_templates')
	@include('client.single.vue.single-product-info-template')
	@include('client.general.vue.info-section-template')
	@include('client.shop.vue.shop-product-template')
@endsection
