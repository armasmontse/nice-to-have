/**
 * MultiImages Vue Component 
 * version 2.0.0-BestBuddies
 */
import _ from 'ramda';
import {crudAjax} from '../mixins/crud-ajax';
var Vue = require('vue');
var VueResource = Vue.use(require('vue-resource'));
import {moveInArray, orderAscending, tapLog} from '../../functions/pure';
import {singleImage} from './single-image';
import Sortable from 'vue-sortable';
Vue.use(Sortable);

export var multiImages = Vue.component('multi-images', {
	template: '#multi-images-template',

	data: function() {
		return {
			children_with_image_order:[],
			ref: this.$options._ref,
			images: [],
			ordered_ids: [],
			type: 'multi-image'
		};
	},

	props: [
		'printable_ref',
		'allPhotos', 
		'photoableType', 
		'photoableId', 
		'use', 
		'defaultOrder', 
		'class', 
		'title',
		'refPath'
	],

	ready() {
		this.images = _.sortBy(_.prop('pivot_order'), _.filter(photo => photo.pivot_use === this.use, this.allPhotos));
		this.printable_ref = Array.isArray(this.refPath) ? this.refPath.join('-') : this.printable_ref;
	},

	mixins: [crudAjax],

	methods: {

		onUpdate($event) {
			let o = $event.oldIndex;
			let n = $event.newIndex;
			this.sort(n - o, o);
			this.$nextTick(() => this.getOrders());
		},

		sort(direction, $index, $event) {
			this.images = moveInArray(direction, $index, this.images);

			Vue.nextTick(()=>{
				this.$broadcast('updateRef, $index');
			});
		},

		getOrders($event) {
			let images = document.querySelectorAll(`.singleImage--${this.printable_ref}_JS`)
			let ids =  _.map(image => image.dataset.id, images)
			this.ordered_ids  = _.filter( id => id !== '',	ids) 
		},

		postOrders($event) {
			this.getOrders();
			this.$nextTick(() => this.post($event))
		},

		onSortSuccess(body) {
			//sólo tiene que estar registrado
		},

		remove(index) {
			this.images.splice(index, 1);
		},

		addSingleImageComponent() {
			this.images.push({});
		},

		onSelectedMedia(data){
			console.log("data", data);
			this.images.unshift(_.merge({type:'single'}, data));
		},
	},

	components: {
		'single-image': singleImage
	}
});
