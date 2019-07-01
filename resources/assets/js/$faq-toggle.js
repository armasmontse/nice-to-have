/**
 * 
 * @param  'section_selector'  debe ser el selector del contenedor de toda la sección
 *                                  	La estructura HTML debe ser:
 *                                  		section_selector
 *                                  			.faq_btn_JS
 *                                  			.faq_caret_JS
 *                                  			.faq_children-container_JS (el que crece y decrece)
 *  @param opts {onOpen, onClose}  métodos opcionales para la ambos eventos, pasan todos los elementos del objeto, dentro de un objeto
 * @return {[type]}                  [description]
 */
export const $faqToggle = (section_selector, opts = {}) => {
	let section = $(section_selector),
		is_open = false

	section.on('click', '.faq_btn_JS', function() {
		let
			parent = $(this).closest(section_selector),
			btn = parent.find('.faq_btn_JS'),
			children = parent.find('.faq_children-container_JS'),
			caret = parent.find('.faq_caret_JS')

		if (!is_open) {
			children.slideDown()

			if (typeof opts.onOpen === 'function') { opts.onOpen({section_selector, caret, btn, parent, children})}

			is_open = true;
		} else {
			children.slideUp()

			if (typeof opts.onClose === 'function') { opts.onClose({section_selector, caret, btn, parent, children})}

			is_open = false;
		}
	})

}