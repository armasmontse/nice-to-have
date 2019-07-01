export const menusStore = {
	menus: {
		userAccount: {
			isOpen: false
		},
		shoppingBag: {
			isOpen: false
		},
		filters: {
			isOpen: false
		},
		shop: {
			isOpen: false
		},
		main: {
			isOpen: false
		},
	}
};

export const menusMixin = {
	methods: {
		toggleMenu(menu_name) {
			this.$dispatch('toggle-menu', menu_name);
		}
	}
};
