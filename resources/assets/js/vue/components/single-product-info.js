import R from 'ramda';
import Vue from 'vue';
import VueTruncate from 'vue-truncate';
import debounce from 'lodash.debounce';
import throttle from 'lodash.throttle';
import {shopProduct} from './shop-product';
import {crudAjax} from '../mixins/crud-ajax';
import {numberFilters} from '../mixins/number-filters';
import {wishlistShoppingBagAjax} from '../mixins/wishlist-shopping-bag-ajax';

Vue.use(VueTruncate);

export const singleProductInfo =  Vue.extend({
	template: '#single-product-info-template',
	mixins: [crudAjax, numberFilters, wishlistShoppingBagAjax],
	props: ['variants', 
			'title', 
			'mainDescription', 
			'id', 
			'clientUrl',
		//for single
			'wishlistLinkAsButton',
		//for wishlist form
			'inWishlist', 
			'isWishlist',
		//for shoppingbag form
			'bagKeys', 
			'skusByPrintableBag', 
			'printableBagIndexByPrintableBagSlug', 
			'isSingle',
			'currentBag',
		//for checkout
			'quantity',
			'selectedSku',
			'bagSlug',
			'isShoppingBag'
			],
	components: {VueTruncate},
	data: function() {
		return {
			remove_form_id: '',
			remove_modal_is_open: false,
			modal_is_open: false,
			dropdown_select_is_open: false,
			selected_variant: {},
			selected_variant_index: -1,
			selected_quantity: 1,
			selected_index: undefined,
			mouse_outside_select: true
		};
	},

	filters: {
		toSlug(s) {
			return s.toLowerCase().split(' ').join('-');
		}
	},

	computed: {
		defaultVariantIndex() {
			return R.findIndex(R.propEq('default', true), R.pathOr([], ['variants'], this));
		},

		selectedVariantWithIndex() {
			if ( this.selected_variant_index !== -1) {
				return R.toUpper(this.selected_variant_index) +'. '+ this.selected_variant.description
			} else{
				return this.selected_variant.description
			}
		}
	},

	ready() {
		if(!this.isSingle) {
			let chosen_variant_index = R.findIndex(R.propEq('sku', this.selectedSku))(this.variants)
			this.selected_variant = R.pathOr({}, ['variants', chosen_variant_index], this);
			this.selected_quantity = R.pathOr(1, ['quantity'], this)
		} else {
			this.selected_variant = R.pathOr({}, ['variants', this.defaultVariantIndex], this);
			this.selected_variant_index = String.fromCharCode(97 +  this.defaultVariantIndex).toUpperCase();
		}
	},

	methods: {
		selectVariant($index) {
			this.selected_variant = $index !== undefined ? R.pathOr({}, ['variants', $index], this) : R.pathOr({}, ['variants', this.defaultVariantIndex], this);
			this.selected_variant_index = String.fromCharCode(97+ $index);
			this.dropdown_select_is_open = false;
		},

		updateBag: throttle(function() {
			let id = `updatebag-${this.bagSlug}-${this.selected_variant.sku}_form`
			this.postBagForm(id)
		}, 5000, {leading: false, trailing:true}),

		postBagForm(id) {
			return this.post(document.getElementById(id))
		},

		inBag(sku, bag) {
			let index = this.printableBagIndexByPrintableBagSlug[bag]
			let skus_of_bag = this.skusByPrintableBag[index] || this.skusByPrintableBag[0] || []
			return R.contains(sku, skus_of_bag);
		},

		isGift(sku) {
			return R.contains(sku, this.$root.store.given_skus || [])
		},

		goToInfoSections() {
			$('body,html').animate({scrollTop: $('#info-sections').offset().top},3000)
		},

		closeOnMouseout() {
			this.mouse_outside_select = true;
			return debounce(() => {
				if (this.mouse_outside_select) {
					this.dropdown_select_is_open = false;
				}
			}, 1000)()
		},

		cancelClose() {
			this.mouse_outside_select = false;
		},

		closeModal() {
			this.modal_is_open = false;
		},

		openRemoveModal(form_id) {
			this.remove_form_id = form_id;
			this.remove_modal_is_open = true;
		},


		closeRemoveModal() {
			this.remove_modal_is_open = false;
		},

		removeItem() {
			this.waiting_for_server = true;
			this.post(document.getElementById(this.remove_form_id));
			this.closeRemoveModal();
		},

		alert() {/*no queremos las alertas automáticas*/}
	}
});
