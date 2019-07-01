const Vue = require('vue');
import {singleImageMixin} from '../mixins/single-image-mixin';

export const singleImage = Vue.component('single-image',{
	template: '#single-image-template',
	mixins:[singleImageMixin]
});
