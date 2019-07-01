import Vue from 'vue';
import {numberFilters} from '../mixins/number-filters';
import {swiperSlider} from '../../swiper-slider';

export var shopProduct =  Vue.extend({
	template: '#shop-product-template',
	props:['name', 'price', 'img_url', 'link'],
	mixins: [numberFilters],
	ready() {
		if (document.querySelector('.swiper-container')) {
			swiperSlider('.relatedProducts__slider')
		}
	}
});
