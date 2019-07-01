import R from 'ramda';
import {shoppingBagDataAndComputedProps} from '../mixins/shopping-bags-data-and-computed-props';

export const user = {
	mixins: [shoppingBagDataAndComputedProps],
	computed: {
		productsInWishlist() {
			return R.filter(product => R.contains(product.id, this.store.products_in_wishlist), this.store.user_products);
		}
	}
};
