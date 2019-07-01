import {onDocumentClick} from '../../functions/dom';

export const basicMenuToggle = {
	data: function() {
		return {
			_menu_toggle_selector: ''
		}
	},

	methods: {
		setUpMenuToggle(id_selector) {
			this._menu_toggle_selector = document.getElementById(id_selector);
			onDocumentClick(this.hideMenu);
		},

		toggleMenu() {
			let bag_display = this._menu_toggle_selector.style.display;
			if (bag_display === 'block') {
				this.hideMenu();
			} else {
				this.showMenu();
			}
		},
		showMenu() {
			this._menu_toggle_selector.style.display = 'block';
		},

		hideMenu() {
			this._menu_toggle_selector.style.display = 'none';
		}
	}
};
