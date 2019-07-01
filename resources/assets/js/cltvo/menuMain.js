import {w} from './constants.js';

export var fixedSidebarWidth = function(elem) {
	var elem = $(elem),
		parent = $(elem[0].parentNode),
		setWidth = () => elem.width(parent.width());
	setWidth();
	w.on('resize', setWidth);
};

export var positionX = function(ref, elem, offset) {
	var ref = $(ref),
		elem = $(elem),
		original_offset = offset,
		extra_offset = offset + 54,
		setPosX = () => elem.css('left', ref.offset().left + offset, 10);
	setPosX();
	w.on('resize', setPosX);
};
