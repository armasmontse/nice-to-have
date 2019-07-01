import {w} from './constants.js';
/**
 * Importante inicializar menu en el w.load
 * @param  {[type]} $ [description]
 * @return {[type]}   [description]
 */
export var menu = function($){
	return {
		menu: $('#menuMain'),
		menu_container: $('#menuMain__container'),
		icon: $('#menuMain__icon'),
		link: $('.menuMain__link'),
		link_container: $('.menuMain__link-container'),
		is_open: false,

		init: function(menu_name) {
			var self = this;
				self.setMenu(menu_name);
				self.toggleMenu();
		},

		onResize: function(func_arr) {
			var self = this;
			$(window).on('resize', function() {
				cltvo.array.runFuncs(func_array);
			});
		},

		setMenu: function(menu_name) {
			this.menu = $('#' + menu_name);
			this.menu_container = $('#' + menu_name + '__container');
			this.icon = $('#' + menu_name + '__icon');
			this.menu_link = $('.' + menu_name + '__link');
			this.menu_link_container = $('.' + menu_name + '__link-container');
		},

		toggleMenu: function() {
			var self = this;
			this.icon.on('click', function() {
				if (! self.is_open) {
					self.open();
				} else {
					self.close();
				}
			});
		},
	};
}(jQuery);
