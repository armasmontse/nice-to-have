import R from 'ramda';
var Vue = require('vue');
import {singleImageMixin} from '../mixins/single-image-mixin';
import {numberFilters} from '../mixins/number-filters';
import {initPropsFromJSON} from '../helpers';

export const singleEvent = Vue.extend({
	template: '#single-event-template',
	mixins: [singleImageMixin, numberFilters],
	props:['type', 'list'],
	ready() {
		initPropsFromJSON.call(this, this.$options.props);
		// this.setRef();
		this.image.src = R.pathOr('', ['thumbnail_url'], this.currentImage);
		this.image.id = R.pathOr('', ['id'], this.currentImage);
		this.order = R.pathOr((this.defaultOrder || null), ['currentImage', 'order'], this);
		this.printable_ref = this.photoableId;// se usa para desasociar correctamente la imagen pues el v-ref es igual para todos: list
	}
});
