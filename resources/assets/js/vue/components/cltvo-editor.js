import Vue from 'vue';

export var cltvoEditor = Vue.component('cltvo-editor',{
	template: '#cltvo-editor-template',

	props: [
		'value',
		'form',
		'name',
		'label'
	],

	data() {
		return {
			value_: this.value !== null ? this.value : ''
		}
	},

	watch: {
		value () {
			this.value_ = this.value !== null ? this.value : '';
		},

		value_() {
			if (this.value !== this.value_) {
				this.value = this.value_; //si reescribimos la prop :(
			}
		}
	}
});