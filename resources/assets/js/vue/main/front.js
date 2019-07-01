import R from 'ramda';
import {shoppingBagDataAndComputedProps} from '../mixins/shopping-bags-data-and-computed-props';
import {swiperSlider} from '../../swiper-slider';

export const front = {
	mixins: [shoppingBagDataAndComputedProps],

	ready() {
		//console.log('front vue');
		if (document.querySelector('.swiper-container')) {
			swiperSlider('.home__slider')
		}

		if(R.pathOr(false, ['personalBagProductsWithSelectedSkusQuantitiesAndPrices', 'length'], this) > 0) {
			this.shown_cart = 'personal'
		} else if(R.pathOr(false, ['mesaBagProductsWithSelectedSkusQuantitiesAndPrices', 'length'], this) > 0) {
			this.shown_cart = 'mesa'
		}
	},

	data: {
		shown_cart: 'personal'
	},

	methods: {
		showCart(cart_name) {
			this.shown_cart = cart_name
		}
	}
};
