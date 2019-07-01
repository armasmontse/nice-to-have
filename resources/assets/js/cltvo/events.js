import {w} from './constants.js';
export var onScroll = (fn) => {
	w.on('scroll', fn)
};

export var onResizeToo = function(fn) {
	if (typeof fn === 'function') {
		fn();
		w.on('resize', fn);
	}
};