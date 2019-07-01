import R from 'ramda';
import Vue from 'vue';
import VueResource from 'vue-resource';
import VueTouch from 'vue-touch';
import {crudAjax} from './mixins/crud-ajax';
import {menusStore} from './mixins/menus';
import {JsonParseOrFalse} from '../functions/pure';
import {ifElementExistsThenLaunch} from '../functions/dom';
import {logoSwitch} from '../logoManipulations';
import {menuTreeToggler} from '../menu-tree-toggler';

Vue.use(VueTouch);

Vue.use(VueHtml5Editor, {
	name: 'v-editor',
	hiddenModules: [
        "color",
        "font",
        "list",
        "tabulation",
        "image",
        "full-screen",
        "info",
    ]
});

Vue.use(VueResource);
export const mainVue = function(config ={}, components = {}) {
	let store = mainVueStore,
		data = config.data || {},
		mixins = R.concat([crudAjax], (config.mixins || []));

	data.store = R.mergeAll([store, (data.store || {}), menusStore]);

	Vue.transition('slide', {
	  enterClass: 'slideInLeft',
	  leaveClass: 'slideOutLeft'
	});

	Vue.transition('fade', {
	  enterClass: 'fadeIn',
	  leaveClass: 'fadeOut'
	});

	return new Vue({
		el: config.el || 'body',

		init() { if(typeof config.init === 'function') return config.init.call(this);},

		created() {
			let stored_objs = R.keys(this.store);
			R.forEach(obj =>{
				let url = R.path(['store', obj, 'routes', 'get'],this);
				if (url) {
					this.get(url, {data: {callee: obj}});
				}
			}, stored_objs);

			this.store.languages = JsonParseOrFalse(this.store.languages);

			if(typeof config.created === 'function') return config.created.call(this);
		},

		ready() {
			ifElementExistsThenLaunch([
				['#header__logo', logoSwitch, 'init', []],
			]);
			if(typeof config.ready === 'function') return config.ready.call(this);
		},

		data: data,

		computed: R.merge({
			bodyScrollIsDisabled() {
				return R.pathOr(false, ['store', 'menus','main', 'isOpen'], this) ||
						R.pathOr(false, ['store', 'menus','shop', 'isOpen'], this) ||
						R.pathOr(false, ['store', 'menus','filters', 'isOpen'], this);
			}
		},config.computed || {}),

		methods: R.merge({
			onGetSuccess(body, data) {
				this.store[data.callee].data = body;
			},
			closeOpenStuff(args) {
				this.$emit('toggle-menu', undefined)
				if(config.closeOpenStuff === 'function') {config.closeOpenStuff(args)}
			},
			toggleMenu(menu_name) {
				this.$emit('toggle-menu', menu_name)
			}
		},config.methods || {}),


		mixins: mixins,

		events: R.merge({
			'toggle-menu': function(menu_name) {
				let other_menus_names = R.filter(menu => menu !== menu_name, R.keys(this.store.menus));

			R.forEach(menu_name => {

				if (R.path(['store', 'menus', menu_name], this)) {
						this.store.menus[menu_name].isOpen = false;
					}
				}, other_menus_names);
				if (R.path(['store', 'menus', menu_name], this)) {
					this.store.menus[menu_name].isOpen = !this.store.menus[menu_name].isOpen;
				}
			}
		}, config.events || {}),

		watch: config.watch || {},

		components: R.merge(components, config.components || {})
	});
};
