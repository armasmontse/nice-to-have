export const faqToggleOptions = {
	onOpen({section_selector, caret, btn, parent, children}) {
		let svg = caret.find('svg')
		svg.addClass('flip');
	},
	onClose({section_selector, caret, btn, parent, children}) {
		let svg = caret.find('svg')
		svg.removeClass('flip');
	}
}