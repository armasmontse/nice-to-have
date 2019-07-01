import {w, menu_top_height} from './cltvo/constants.js';

export var fixedSideBarScroller = function() {
	var sidebar = $('#grid__fixedElem_JS'),
		toggle_position = 400;

	var setTogglePosition = function() {
		return sidebar.offset().top - menu_top_height - 80;
	};

	var fix = function() {
		if(w.scrollTop() > toggle_position && w.width() > 768 ) {
			sidebar.addClass('active')
		} else {
			sidebar.removeClass('active')
		}
	};

	w.on('load', function() {
		setTogglePosition();
		fix();
	});

	w.on('resize', function () {
		fix();
	});
	w.on('scroll', function() {
		fix();
	});

};