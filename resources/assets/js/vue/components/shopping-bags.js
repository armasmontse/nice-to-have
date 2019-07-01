import R from 'ramda';
import debounce from 'lodash.debounce';
import {shoppingBagMaker} from '../factories/shopping-bag-maker';
import {menusMixin} from '../mixins/menus';


/**
 * Shopping Bags Vue Components
 *
 * @version 1.0.1-NTH
 */
export const shoppingBagMenu =  shoppingBagMaker({
	template: '#shopping-bag-menu-template',
	mixins:[menusMixin],
	props: ['isOpen'],
});



export const cartBag = (template, opts) =>({
	template: template,

	props: R.concat(['iva', 'isShoppingBag', 'shipping', 'discountCode',  'termsAccepted', 'bagSlug', 'shopUrl'], opts.props || []),

	data: R.merge({}, opts.data),

	computed: R.merge({
		iva_price() {
			return this.products_total_price * (1 - 1/(1 + (this.iva/100)));
		},

		subtotal() {
			return this.products_total_price / (1 + (this.iva/100));
		},

		order_total() {
			if (this.isShoppingBag) {
				return this.subtotal + this.iva_price;
			} else {
				return this.subtotal + this.iva_price + this.shipping_costs;
			}
		},

		total_items_in_bag() {
			return R.sum(R.pluck('quantity', this.bag));
		}

	}, opts.computed || {}),

	methods: {

//----Por si luego hay Códigos de Descuento
/*
		calculateDiscountCodeValue(total) {
			this.discount = total * this.discount_code_value/100;
		},

		verifyDiscountCode: debounce(function(form_id) {
			if (this.discountCode === '') {return;}
				this.post(document.getElementById("verifydiscountcode_form"));
		}, 1000),

		onVerifydiscountcodeSuccess(body) {
			this.discount_code_value = body.data.value;
		}
	},

	watch: {
		discount_code_value() {
			this.calculateOrderTotal();
		},

		shipping: {
			handler() {
				this.calculateOrderTotal();
			},

			deep: true
		}
 */
	}
})


const checkoutBag = (template, opts) => ({
	template,
	
	methods: opts.methods || {},

	data: R.merge({
		is_checkout: true,
		place_order_button_active: false,
	}, opts.data || {}),

	props: R.concat([
		'iva',
		'bagTotals',
		'inZonaMetropolitana',
		'friendlyMessageCard',
		'isEvent',
		'discountInfo'], opts.props || []),

	computed: R.merge({
		subtotal() {
			return this.bagTotals.price_with_discounts / (1 + (this.iva/100));
		},

		iva_price() {
			return this.bagTotals.price_with_discounts * (1 - 1/(1 + (this.iva/100)));
		},

		shipping_costs() {
			if(this.inZonaMetropolitana === undefined) {return 0};
			if (this.isEvent) {
				return 0
			}
			if (this.dynamic_shipping_costs !== -0.001) {//porque no siempre tenemos disponible una bolsa para calcular los costos (especificament en el checkout)
				return this.dynamic_shipping_costs;
			} else {
				return this.inZonaMetropolitana ? this.bagTotals.local_shipping_rate : this.bagTotals.national_shipping_rate;
			}
		},

		friendly_card_price() {
			let preds = this.friendlyMessageCard === true && this.isEvent;
			return preds ? this.$root.store.friendly_message_card_price : 0;
		},

		discount() {
			let discount_type = R.path(['discountInfo', 'type'], this);
			return {
				porcentaje_descuento: -1*(this.subtotal + this.iva_price + this.shipping_costs + this.friendly_card_price) * this.discountInfo.value/100,
				credito: -1*this.discountInfo.value,
				envio_gratis: -1*this.shipping_costs
			}[discount_type] || 0;
		},

		order_total() {
			return this.subtotal + this.iva_price + this.shipping_costs + this.friendly_card_price + this.discount;
		},

		total_items_in_bag() {
			return this.bagTotals.items
		}
	}, opts.computed || {})
})

const eventCheckoutBag = {
	props: [
		'balance',
		'minimum',
		'feePercentage',
		 'bagTotals',
		 'inZonaMetropolitana',
		'isShoppingBag',
		'closeEmptyBag'
	],

	data: {
		close_empty_bag_modal_is_open: false,
		accept_terms: false, //usada cuando la bolsa esta vacia
	},

	computed: {
		is_over_minimum() {//la compra va sobre la cantidad m'inima requerida
			let is_over_minimum = this.order_total >= this.minimum;
			if (typeof this.onOverMinimumChange === 'function') { this.onOverMinimumChange(is_over_minimum);}
			return is_over_minimum;
		},

		total_to_be_paid() {
			let total =  this.order_total - this.balance;
			return total > 0 ? total : 0;
		},

		balance_to_be_transfered() {
			let balance = this.balance - this.order_total;
			return balance > 0 ? balance : 0;
		},

		transfer_fee() {
			return this.balance_to_be_transfered * this.feePercentage/100;
		},

		transfer_total() {//el change de esta propiedad hace un $dispatch de onTransferTotalChange
			let total = this.balance_to_be_transfered - this.transfer_fee;
			if (typeof this.notifyParentOnTransferTotalChange === 'function') { this.notifyParentOnTransferTotalChange(total);}
			return this.balance_to_be_transfered - this.transfer_fee;
		},

		shipping_costs() {
			if(this.inZonaMetropolitana === undefined) {return 0};
			if (this.dynamic_shipping_costs !== -0.001) {
				return this.dynamic_shipping_costs
			} else {
				return this.inZonaMetropolitana ? this.bagTotals.local_shipping_rate : this.bagTotals.national_shipping_rate;
			}
		},

		order_total() {
			let discount = typeof this.discount === 'number' ? this.discount : 0;//basicamente, cuando se trate del carrito
			return this.subtotal + this.iva_price + this.shipping_costs + discount;
		},
	},

	methods: {
		notifyParentOnTransferTotalChange(total) {
			this.$dispatch('onTransferTotalChange', total);
		},

		onOverMinimumChange(is_over_minimum) {
			this.$dispatch('onOverMinimumChange', is_over_minimum);
		}
	}
}
//exportamos para testear
export const normalCart = cartBag('#shopping-bag-with-prices-template', {})
export const normalCheckout = checkoutBag('#shopping-bag-for-checkout-template', {})
export const eventCart = cartBag('#shopping-bag-with-prices-for-event-template', eventCheckoutBag);
export const eventCheckout = checkoutBag('#shopping-bag-for-event-checkout-template', eventCheckoutBag);

//exportamos para micorriza
//para carrito
export const shoppingBagWithPrices = shoppingBagMaker(normalCart);
export const shoppingBagWithPricesForEvent = shoppingBagMaker(eventCart);
//para checkout
export const shoppingBagForCheckout = shoppingBagMaker(normalCheckout);
export const shoppingBagForEventCheckout = shoppingBagMaker(eventCheckout);
