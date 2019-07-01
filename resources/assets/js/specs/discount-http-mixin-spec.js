import R from 'ramda'
import Vue from 'vue'
import {discountHTTP} from '../vue/mixins/discount-http';

describe('discount-http.js', () => {
	let vm = {}

	beforeEach(() => {
		vm = new Vue({
			replace:false,//no es necesario fuera del test, es sólo para cuando usamos el método mount sobre el body
			template: `
			<div>
				<input type="text" value="abc" v-model="discount_code">
			</div>`,
			mixins: [discountHTTP],
			data: {
				store: {
					bla1: 1,
					bla2: 2,
					discount_codes_types: [
						{
							id: 1, 
							name: 'porcentaje_descuento'
						},
						{
							id: 2, 
							name: 'envio_gratis'
						},
						{
							id: 3, 
							name: 'credito'
						}
					]
				},
			},

			methods: {
				generalError: function(){},
				post: function(){}
			}
		})

		spyOn(vm, 'generalError')
		spyOn(vm, 'post')
	}) 
	
	it('initializes the following $data props: discount_code, store.discount -- and the set up does not disturb other properties in the store', function() {
		expect(vm.discount_code).toEqual('')
		expect(vm.store.discount).toEqual({})
		expect(vm.store.bla1).toEqual(1)
		expect(vm.store.bla2).toEqual(2)
	});

	it('Post data in an input that has the discount_code via makePost, which recieves the form_id as an argument. The form should be named "discountcodevalidation_form" ', function(done) {
		vm.makePost('discountcodevalidation_form')
		Vue.nextTick(() => {
			expect(vm.post).toHaveBeenCalled()
			done()
		});
	});

	it('Receives a valid object: posts a code to the server for verification and receives an object that it can process into a discountInfo object to be consumed elsewhere', function(done) {
		vm.post = function(code) {
			let body = {
				data: {
					code,
					id: 1,
					description: 'bla',
					value: 50,
					unique: 0, 
					discount_code_type_id: 1
				}
			}
			this.onDiscountcodevalidationSuccess(body)
		}

		vm.post('un codigo válido')

		Vue.nextTick(() => {
			expect(vm.store.discount).toEqual({
				type: 'porcentaje_descuento',
				value: 50
			})
			done()
		});
	});

	it('Muestra un mensaje de error al usuario si no se encuentra el discount_code_type_id en el store.discount_codes_types', function(done) {
		vm.post = function(code) {
			let body = {
				data: {
					code,
					id: 1,
					description: 'bla',
					value: 50,
					unique: 0, 
					discount_code_type_id: 5
				}
			}
			this.onDiscountcodevalidationSuccess(body)
		}

		vm.post('un codigo válido')

		Vue.nextTick(() => {
			expect(vm.generalError).toHaveBeenCalled()
			done()
		});
	});

	it('can bind a starting value to the v-model', function(done) {
		vm.$mount('body')
		Vue.nextTick(() => {
			expect(vm.discount_code).toEqual('abc');
			done()
		})
	});

	it('posts the discount code on ready(), when the value of the model is not an empty string', function(done) {
		vm.$mount('body')
		Vue.nextTick(() => {
			expect(vm.post).toHaveBeenCalled()
			done()
		})
	});

})


