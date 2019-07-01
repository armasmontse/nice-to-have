import {w} from './cltvo/constants.js';

export const logoSwitch = {
	header_logo: $('#header__logo svg'),
	header_logo_bottom_position: 0,
	menu_top: $('#menuTop'),
	menu_top_logo: $('#menuTop__logo'),
	init() {
		let self = this;
		this.setHeaderLogoBottomPosition()
			.toggleMenuTopLogo();
		w.on('scroll', () => {
			this.toggleMenuTopLogo();
		});
	},

	setHeaderLogoBottomPosition() {
		this.header_logo_bottom_position = this.header_logo.offset().top + this.header_logo.height();
		return this;
	},

	toggleMenuTopLogo() {
		w.scrollTop() > (this.header_logo_bottom_position - 34) 
			? this.menu_top_logo.fadeIn() 
			: this.menu_top_logo.fadeOut();
	}
};