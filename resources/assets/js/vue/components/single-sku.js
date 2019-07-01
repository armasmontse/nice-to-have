import R from 'ramda';
var Vue = require('vue');
import {singleImageMixin} from '../mixins/single-image-mixin';
import {numberFilters} from '../mixins/number-filters';
import {initPropsFromJSON} from '../helpers';

export const singleSku = Vue.extend({
	template: '#single-sku-template',
	mixins: [singleImageMixin, numberFilters],
	props:['sku', 'list'],
	ready() {
		initPropsFromJSON.call(this, this.$options.props);
		this.image.src = R.pathOr('', ['thumbnail_url'], this.currentImage);
		this.image.id = R.pathOr('', ['id'], this.currentImage);
		this.order = R.pathOr((this.defaultOrder || null), ['currentImage', 'order'], this);
		this.printable_ref = this.photoableId;// se usa para desasociar correctamente la imagen pues el v-ref es igual para todos: list
	},

});
