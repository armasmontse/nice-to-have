import R from 'ramda';
import Vue from 'vue';
import VueResource from 'vue-resource';
import {crudAjax} from '../mixins/crud-ajax';
import {singleImageMixin} from '../mixins/single-image-mixin';
import {vForFilters} from '../mixins/v-for-filters.js';
import {initPropsFromJSON} from '../helpers';
import {pairObjToIdProp, arrsIntoObjs} from '../../functions/pure';

Vue.use(VueResource);
/**
 * Index of factories
 *
 * 	simpleCrud,
 * 	simpleCrudWithImage,
 * 	simpleModalCrud
 */

export const simpleCrud = R.curry(function(template, options = {}) {
	return Vue.extend({
		template: template,
		data: function(){
			return R.merge({
				edit_index: -1
			}, options.data || {})
		},
		props: R.uniq(['list'].concat(options.props || [])),

		watch: options.watch || {},

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

		events: options.events || {},

		computed: R.merge({
					list_with_langs() {
						return R.map(obj =>
							R.head(R.map(R.merge(obj))(//agrega el objeto a obj y lo saca del array que esta haciendo la iteraci'on
								arrsIntoObjs(//lo vuelve un objeto {es:lang_obj}
								R.map(pairObjToIdProp('iso6391'))//lo pone dentro del lenguaje i.e [es, lang_obj]
	 		 					(R.pathOr({}, ['languages'], obj)))))//trae el objeto i.e lang_obj
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
});

export const simpleCrudWithImage = R.curry((template, options) => {
	let mixins = R.concat([singleImageMixin], options.mixins || []);
	let data = R.merge({}, options.data || {});
	let ready = function() {
		initPropsFromJSON.call(this, this.$options.props);
		this.setRef();
		this.image.src = R.pathOr('', ['thumbnail_url'], this.currentImage);
		this.image.id = R.pathOr('', ['id'], this.currentImage);
		this.order = R.pathOr((this.defaultOrder || null), ['currentImage', 'order'], this);
		this.printable_ref = this.photoableId;// se usa para desasociar correctamente la imagen pues el v-ref es igual para todos: list
		if (typeof options.ready === 'function') { options.ready.call(this)};
	};
	return simpleCrud(template, 
		R.merge(options, {data, mixins, ready})
		);
});

export const simpleModalCrud = R.curry(function(template, config ={}) {
	let template_index = R.lastIndexOf('-template', template);
	let name = R.take(template_index, template);

	let modal_config = {
			dismissible: true, // Modal can be dismissed by clicking outside of the modal
			opacity: 0.5, // Opacity of modal background
			in_duration: 100, // Transition in duration
			out_duration: 300, // Transition out duration
			starting_top: '20%', // Starting top style attribute
			ending_top: 0, // Ending top style attribute
			ready: function(modal, trigger) {},
			complete: function() { }
	};

	config.methods = config.methods || {};

	if (template_index === -1) {
		console.error(`[simpleModalCrud]  La variable "template" carece de de terminación "-template", se ingresó ${template}`);
	}

	let modalOptions = {
		ready() {
			let modal = $(name);
			if (modal.length === 0) {
				console.error(`[simpleModalCrud]  El modal que se quiere usar no existe, simpleModalCrud está buscando una modal que tenga el siguiente selector "${name}"`);
				return;
			}
			this.modal = modal.modal(modal_config);
			if (typeof config.ready === 'function') { config.ready.call(this)};
		},

		components: R.merge({}, config.components || {}),

		mixins: [].concat(config.mixins || []),

		props: ['editIndex', 'list'].concat(config.props || []),
		events: config.events || {},

		data: R.merge({
			modal: $(name),
			item_on_edit: {}
		}, config.data || {}),

		computed: R.merge({
		}, config.computed || {}),

		methods: R.merge(config.methods, {

			onCreateSuccess(body, input) {
					this.list.splice(0, 0, body.data);
					input.target.reset();
					this.modal.modal('close');
			},

			onUpdateSuccess(body, input) {
					let index = input.target.dataset.index;
					this.list.splice(index, 1, body.data);
					this.modal.modal('close');
			}
		}),

		watch: R.merge({
			editIndex() {
				this.item_on_edit = this.list[this.editIndex];
			}
		}, config.watch || {})
	};
	return simpleCrud(template, modalOptions);
});
