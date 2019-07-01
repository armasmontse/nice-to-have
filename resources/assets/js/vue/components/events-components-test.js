import Vue from 'vue';
import {numberFilters} from '../mixins/number-filters';
import {swiperSlider} from '../../swiper-slider';

export const comp1 =  Vue.extend({
	template: '#comp1-template',
	props: ['content'],
	data: function() {
		return {
			type: 'comp1', 
			position: {},
		}
	},

	ready() {
		this.positioning();
	},

	methods: {
		positioning() {
			this.position = {
				'webkitTransform': 'translateX(20px)'
			}
		},
	}
});

export const comp2 =  Vue.extend({
	template: '#comp2-template',
	props: ['content'],
	data: function() {
		return {
			type: 'comp2',
		}
	},
	ready() {
	}
});

export const comp3 =  Vue.extend({
	template: '#comp3-template',
	props: ['content'],
	data: function() {
		return {
			type: 'comp3',
		}
	},
	ready() {
	}
});
