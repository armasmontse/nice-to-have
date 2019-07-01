import R from 'ramda';
import Vue from 'vue';
import {crudAjax} from '../mixins/crud-ajax';
import {initPropsFromJSON} from '../helpers';
import {pairObjToIdProp, arrsIntoObjs} from '../../functions/pure';
import {vForFilters} from '../mixins/v-for-filters.js';
import VueResource from 'vue-resource';
Vue.use(VueResource);

export var simpleCrudComponentMaker = function(template, options = {}) {
	return Vue.extend({
		template: template,
		data: () => R.merge({}, options.data || {}),
		props: ['list'].concat(options.props || []),

		watch: options.watch || {},

		events: options.events || {},

		created() {
			if(typeof options.create === 'function') options.create.call(this);
		},

		init() {
			if(typeof options.init === 'function') options.init.call(this);
		},

		ready() {
			// initPropsFromJSON.call(this, this.$options.props);//En el proximo nuevo proyecto corregir esta linea, debe usarse la funcion initPropsFromJSON
			if(typeof options.ready === 'function') options.ready.call(this);
		},

		mixins: [crudAjax, vForFilters].concat(options.mixins || []),

		filters: options.filters || {},

		computed: R.merge({
					list_with_langs() {
						return R.map(obj => 
							R.head(R.map(R.merge(obj))(arrsIntoObjs(R.map(pairObjToIdProp('iso6391'))(R.pathOr({}, ['languages'], obj)))))
						)(this.list || [])
					}
				}, options.computed),

		methods: R.merge({
					onGetSuccess(body){
						this.list = body;
					}
				}, options.methods),
		components: options.components || {}
	});
};
