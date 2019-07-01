import Vue from 'vue';
import {numberFilters} from '../mixins/number-filters';

export var shopProduct =  Vue.extend({
	template: '#shop-product-template',
	props:['name', 'price', 'img_url', 'link', 'is_published', 'isEventShop'],
	mixins: [numberFilters]
});
