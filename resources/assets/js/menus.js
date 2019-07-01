
import {menu} from './cltvo/menu.js';
export var main = Object.create(menu);

main.is_open = true;
main.has_been_closed = false;

main.toggleMenu = function() {
	var self = this;
	this.icon.on('click', function() {
		if (! self.is_open) {
			self.open();
		} else {
			self.has_been_closed = true;
			self.close();
		}
	});
};

main.open = function() {
	this.link.fadeIn();
	this.is_open = true;
};

main.close = function() {
	this.link.fadeOut();
	this.is_open = false;
};

import {w} from './cltvo/constants.js';
import {myarr} from './cltvo/constants.js';
import {onScroll} from './cltvo/events.js';

main.fixMenu = function() { 
	let fixing_position = this.menu.offset().top - $('#menuTop').height(),
		body = $('body'),
		header_mb = parseInt($('header').css('marginBottom'));
	w.on('scroll', () => {
		if (w.scrollTop() >= fixing_position && w.width() > 768) {
			this.menu.addClass('sticky');
			if (!body.hasClass('splash__body')) {//porque el header en el body ya tiene posición absoluta, entonces no hay que compensar
				body.css('paddingTop', this.menu.outerHeight() + header_mb);
			}
		} else {
			this.menu.removeClass('sticky');
			body.css('paddingTop', 0);
		}
	});
};


export var mobile = Object.create(main);
mobile.is_open = false;
mobile.open = function() {
	this.menu.fadeIn();
	this.is_open = true;
};

mobile.close = function() {
	this.menu.fadeOut();
	this.is_open = false;
};

mobile.menu_icon_class = $('.menuResponsive__icon');
mobile.menu_icon_class.on('click', () => {
	mobile.open();
});
