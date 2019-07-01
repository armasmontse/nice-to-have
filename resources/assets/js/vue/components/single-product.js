import R from 'ramda';
import Vue from 'vue';
import {shopProduct} from './shop-product';
import {singleProductInfo} from './single-product-info';
import {infoSection} from './info-section';
import {numberFilters} from '../mixins/number-filters';
import {swiperSlider} from '../../swiper-slider';


export const singleProduct =  Vue.extend({
	template: '#single-product-template',
	mixins: [numberFilters],
	props: [
		'product',
		'currentLanguage',
		'productsInWishlist',
		'bagKeys',
		'skusByPrintableBag',
		'printableBagIndexByPrintableBagSlug',
		'isEventShop',
		'bagSlug',
		'isShoppingBag'
	],
	components: {shopProduct, infoSection, singleProductInfo},
	data: function() {
		return {
			dropdown_select_is_open: false,
		};
	},

	computed: {
		title() { return R.pathOr('', ['product', 'title'], this);},
		description() { return R.pathOr('', ['product', 'description'], this);},
		variants() {
			return R.map(sku => {
				return {
					image_url: R.pathOr('', ['thumbnail_image', 'url'], sku),
					price: R.pathOr('', ['price_with_discount'], sku),
					description: R.pathOr('', ['description'], sku),
					default: sku.default,
					sku: R.pathOr('sku no encontrado', ['sku'], sku)
				};
			}, R.pathOr([], ['product', 'skus'], this));
		},

		photos() {
			return R.compose(R.mergeAll, R.sortBy(R.prop('0')), R.map(photo => ({[photo.pivot_order]: photo.url})))(R.pathOr([], ['product', 'photos'], this));
		},

		info_sections() {
			let sorted_sections = R.sortBy(R.prop('order'), (R.pathOr([], ['product', 'product_sections'], this)));
			return R.map(section => ({
				title: section.title,
				content: section.br_content
			}), sorted_sections);
		},

		relatedProducts() {
			return R.map(product => {
				return {
					img_url: R.pathOr('', ['default_sku', 'thumbnail_image', 'url'], product),
					price: R.pathOr('', ['default_sku', 'price_with_discount'], product),
					name: R.pathOr('', ['title'], product),
					client_url: R.pathOr('', ['client_url'], product),
					event_shop_url: R.pathOr('', ['event_shop_url'], product),
					is_published: R.pathOr(false, ['is_publish'], product )
				};
			}, R.filter(product => product.default_sku !== null, R.pathOr([], ['product', 'products_related'], this)) );
		},

		in_wishlist() {
			return R.contains(this.product.id, this.productsInWishlist);
		}
	},

	ready() {
		if (document.querySelector('.swiper-container')) {
			swiperSlider('.relatedProducts__slider')
		}
	},

	methods: {
		selectVariant($index) {
			this.selected_variant = this.variants[$index];
			this.dropdown_select_is_open = false;
		}
	}

});
