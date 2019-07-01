import R from 'ramda';
import {w, document_click_callbacks} from '../cltvo/constants.js';

/**
 * Permite ejecutar múltiple callbacks en el evento document.onclick
 * @requires La constante {array} document_click_callbacks
 */
export const documentClickHandlersLauncher = function(){
	var cltvoOnClick = function cltvoOnClick() { R.forEach(cb => cb(), document_click_callbacks)};
	document.onclick = cltvoOnClick;
};

/**
 * Agrega callbacks a al array document_click_callbacks
 * @param  {function} handler 
 * @requires La constante {array} document_click_callbacks
 */
export const onDocumentClick = handler => {if(typeof handler === 'function') document_click_callbacks.push(handler)};

export const cltvoEventsWarnings = () => {
	if(R.path(['name'], document.onclick) !== 'cltvoOnClick') {
		console.error('[Micorriza Warn] You might be overwritting the "cltvoOnClick" event handler, please use the "onDocumentClick" function instead to avoid overwritting other callbacks that might be attached to this event. If "cltvoOnClick" has not been registered, run this function on your JS entry point "documentClickHandlersLauncher".');
	}
};


export const fixedSidebarWidth = function(elem) {
	var elem = $(elem);
	if (elem[0] === undefined) { return;}
	var	parent = $(elem[0].parentNode),
		setWidth = () => elem.width(parent.width());
	setWidth();
	w.on('resize', setWidth);
};

export const positionX = function(ref, elem, offset) {
	var ref = $(ref),
		elem = $(elem),
		original_offset = offset,
		extra_offset = offset + 54,
		setPosX = () => elem.css('left', ref.offset().left + offset, 10);
	setPosX();
	w.on('resize', setPosX);
};


export const parentContainerWidth = function(elem) {
	var elem = $(elem),
		parent_width = elem[0].offsetParent.offsetWidth,
		setWidth = () => elem.width(parent_width);
		w.on('resize', setWidth);
		return parent_width;
};

/**
 * Esta función regista cualquier otra función que requiera la existencia de ciertos elementos en el DOM y permite invocarla solo cuando esos elementos existen.
 *
 * Su principal objetivo es prevenir los errores de tipo:
 * 		"Uncaught TypeError: Cannot read property [x] of undefined"
 *
 * Recibe un array con los siguientes parámetros:
 *
 * @param 'string' DOM Node
 * @param 'function'
 * @param 'array' The functions parameters
 *
 * IMPORTANTE: De momento solo acepta un único elemento del DOM, como primer parámetro, pero la función invocada puede requerir de otros nodos. En un futuro debería aceptar un array con todas las dependencias de estas funciones.
 */
export const ifElementExistsThenLaunch = function(arr_with_ID_or_class_and_fn) {
	arr_with_ID_or_class_and_fn.map(function(arr) {
		if (document.querySelectorAll(arr[0]).length > 0) {
			arr[2] ? arr[1][arr[2]].apply(arr[1], arr[3]) : arr[1].apply(this, arr[3]);
		}
	});
};


export const preSelectOption = (select_id, option_value) => {
	var options = document.getElementById(select_id).getElementsByTagName('option'),
		selected_option = R.head(R.filter(option => option.value == option_value, options))
		if(selected_option) {selected_option.selected = 'selected';}
};

