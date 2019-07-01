import R from 'ramda';
import Vue from 'vue';
import {menusMixin} from '../mixins/menus';

/**
 * User Account Menu
 *
 * @version 1.0.0-NTH
 */
export const userAccountMenu =  Vue.extend({
	template: '#user-account-menu-template',
	props: ['isOpen'],
	mixins: [menusMixin]
});