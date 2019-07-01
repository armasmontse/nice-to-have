import {numberFilters} from '../mixins/number-filters';
import R from 'ramda';
import Vue from 'vue';
import {crudAjax} from '../mixins/crud-ajax';
import {sumTotalPrice, sumTotal} from '../../functions/pure';

export var shoppingBagMaker = function(config) {
	return Vue.extend({
		template: config.template,
		mixins: R.concat([crudAjax, numberFilters], config.mixins || []),
		props: R.concat([
			'bagKey', 
			'printableBags', 
			'totalItemsInBags', 
			'currency', 
			'exchangeRate', 
			'currentLanguage', 
			'bag', 
			'inZonaMetropolitana'], 
		config.props || []),

		computed: R.merge({
			//products_total_price :: bag [{Number price, Int quantity, *}] -> Number price
			products_total_price() {
				return sumTotalPrice(this.bag || []);
			},

			dynamic_shipping_costs() {//preferir esta cuando inZonaMetropolitana esté disponible
				if (this.inZonaMetropolitana === undefined || this.bag === undefined) {
					// console.error(`[shoppingBagMaker], se requiere pasar "inZonaMetropolitana" para que "dynamic_shipping_costs funcione"`);
					return -0.001;
				}
				if (this.inZonaMetropolitana) {
					return sumTotal('local_shipping_rate', 'quantity', this.bag || []);
				} else {
					return sumTotal('national_shipping_rate', 'quantity', this.bag || []);
				}
			},
		}, config.computed||{}),

		data: function() {
			return R.merge({
			}, config.data || {});
		},

		ready() {
			if(typeof config.ready === 'function') return config.ready.call(this);
		},

		methods: R.merge({
		}, config.methods || {}),

		watch: R.merge({
		}, config.watch || {})
	});
};
