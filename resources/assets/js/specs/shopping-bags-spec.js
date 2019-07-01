import R from 'ramda'
import Vue from 'vue'
import {shoppingBagMaker} from '../vue/factories/shopping-bag-maker';
import {normalCart, normalCheckout, eventCart, eventCheckout} from '../vue/components/shopping-bags';

describe('shopping-bags.js', () => {
	describe('shoppingBagWithPricesForEvent', () => {
		let vm = {}
		let cart = {}
		let twoSkusLocalShipping = 10+5+(20*3)+(7*3)
		let twoSkusNotionalShipping = 10+6+(20*3)+(8*3)

		beforeEach(() => {
			let template = '<div></div>'
			
			const shoppingBagWithPricesForEvent = shoppingBagMaker(R.merge(eventCart, {template}))

			vm = new Vue({
				template: 
				`<div>
					<shopping-bag-with-prices-for-event
						:bag="bag"
						:exchange-rate="store.exchange_rate"
						:iva="store.iva"
						:is-shopping-bag="true"
						:balance="store.balance"
						:minimum="store.minimum"
						:fee-percentage="store.fee_percentage"
						:in-zona-metropolitana="store.address_in_zmvm"
						:bag-totals="store.bag_totals"
						:close-empty-bag="store.close_empty_bag"
					></shopping-bag-with-prices-for-event>
				</div>`,
				data: {
					bag: [
						  {
						    "price": 10,
						    "quantity": 1,
						    "local_shipping_rate": 5,
						    "national_shipping_rate": 6
						  },
						  {
						    "price": 20,
						    "quantity": 3,
						    "local_shipping_rate": 7,
						    "national_shipping_rate": 8
						  }
					],
					store: {
						exchange_rate: 1,
						iva: 16,
						balance: 1000,
						minimum: 300,
						fee_percentage: 5,
						address_in_zmvm: true,
						bag_totals: {},
						close_empty_bag: false,
					}
				},
				components: { shoppingBagWithPricesForEvent }
			}).$mount()
			
			cart = vm.$children[0]
		}) 

		it('is_over_minimum :: Bool -- Changes if order_total is over minimum', (done) => {
			expect(cart.is_over_minimum).toEqual(false);
			vm.store.minimum = 30
			Vue.nextTick(() => {
				expect(cart.is_over_minimum).toEqual(true);
				done();
			})	
		})

		it('total_to_be_paid :: Float -- order_total - balance, but if order_total is smaller than balance then it returns 0', (done) => {
			expect(cart.total_to_be_paid).toEqual(0);
			vm.bag.push({
			    "price": 150,
			    "quantity": 10,
			    "local_shipping_rate": 5,
			    "national_shipping_rate": 6
			  })
			Vue.nextTick(() => {
				expect(cart.total_to_be_paid).toEqual((1500 + 50 + twoSkusLocalShipping) - cart.balance);
				done();
			})	
		})
		
		//standard tests for all bags -implementation might change from one bag to another
		it('calculates the correct amount', () => {
			expect(cart.order_total).toEqual(twoSkusLocalShipping);
		})
		
		it('separates iva, subtotal and shipping_costs from order_total', () => {
			expect(cart.order_total).toEqual(cart.iva_price + cart.subtotal + cart.shipping_costs);
		})

		it('recalculates the correct amount when the inZonaMetropolitana changes', (done) => {
			vm.store.address_in_zmvm = false
			Vue.nextTick(() => {
				expect(cart.order_total).toEqual(twoSkusNotionalShipping);
				done()
			})
		})

		it('recalculates the correct amount when a new Item is added', (done) => {
			vm.bag.push({
			    "price": 15,
			    "quantity": 1,
			    "local_shipping_rate": 5,
			    "national_shipping_rate": 6
			  })

			Vue.nextTick(() => {
				expect(cart.order_total).toEqual(twoSkusLocalShipping + 15 + 5);
				done()
			})
		})

		it('recalculates the correct amount when an item is removed', (done) => {
			vm.bag.splice(1)

			Vue.nextTick(() => {
				expect(cart.order_total).toEqual(10+5);
				done()
			})
		})
		
		it('dynamically calculates the number of items in a bag if an item is added', (done) => {
			expect(cart.total_items_in_bag).toEqual(4)
			
			vm.bag.push({
			    "price": 150,
			    "quantity": 10,
			    "local_shipping_rate": 5,
			    "national_shipping_rate": 6
			  })

			Vue.nextTick(() => {
				expect(cart.total_items_in_bag).toEqual(4+10)
				done()
			})
		})

		it('dynamically calculates the number of items in a bag if an item is removed', (done) => {
			expect(cart.total_items_in_bag).toEqual(4)
			
			vm.bag.splice(1)

			Vue.nextTick(() => {
				expect(cart.total_items_in_bag).toEqual(1)
				done()
			})
		})
	})

	describe('shoppingBagForEventCheckout', () => {
		let vm = {}
		let cart = {}

		beforeEach(() => {
			let template = '<div></div>'
			
			const shoppingBagForEventCheckout = shoppingBagMaker(R.merge(eventCheckout, {template}))

			vm = new Vue({
				template: 
				`<div>
					<shopping-bag-for-event-checkout
						:exchange-rate="store.exchange_rate"
						:iva="store.iva"
						:is-shopping-bag="false"
						:balance="store.balance"
						:minimum="store.minimum"
						:fee-percentage="store.fee_percentage"
						:in-zona-metropolitana="store.address_in_zmvm"
						:bag-totals="store.bag_totals"
						:discount-info="store.discount"
					></shopping-bag-for-event-checkout>
				</div>`,
				data: {
					store: {
						discount: {
							//spec
							//type: String //'percent', 'shipment', 'value'
							//value: Int
						},
						exchange_rate: 1,
						iva: 16,
						balance: 1000,
						minimum: 800,
						fee_percentage: 5,
						address_in_zmvm: false,
						bag_totals: {
							price_with_discounts: 500,
							local_shipping_rate: 200,
							national_shipping_rate: 500
						},
						close_empty_bag: false,
					}
				},
				components: { shoppingBagForEventCheckout }
			}).$mount()
			
			cart = vm.$children[0]
		}) 

		it('is_over_minimum :: Bool -- Changes if order_total is over minimum', (done) => {
			expect(cart.is_over_minimum).toEqual(true);
			vm.store.address_in_zmvm = true
			Vue.nextTick(() => {
				expect(cart.is_over_minimum).toEqual(false);
				done();
			})	
		})

		it('total_to_be_paid :: Float -- order_total - balance, but if order_total is smaller than balance then it returns 0', (done) => {
			expect(cart.total_to_be_paid).toEqual(0);
			vm.store.balance= 500
			Vue.nextTick(() => {
				expect(cart.total_to_be_paid).toEqual(500);
				done();
			})	
		})

		it('balance_to_be_transfered :: Float -- balance - order_total , but if balance is smaller than order_total then it returns 0', (done) => {
			expect(cart.balance_to_be_transfered).toEqual(0);
			vm.store.balance= 1500
			Vue.nextTick(() => {
				expect(cart.balance_to_be_transfered).toEqual(500);
				done();
			})	
		})
		
		it('transfer_fee :: Float', (done) => {
			expect(cart.transfer_fee).toEqual(cart.balance_to_be_transfered * cart.feePercentage/100);//si es negativo no se muestra, pero si se calcula
			vm.store.balance= 1500
			Vue.nextTick(() => {
				expect(cart.transfer_fee).toEqual(500* cart.feePercentage/100);
				done();
			})
		})
		
		//standard tests for all bags -implementation might change from one bag to another
		it('separates iva, subtotal and shipping_costs from order_total', () => {
			expect(cart.order_total).toEqual(cart.iva_price + cart.subtotal + cart.shipping_costs);
		})

		it('recalculates the correct amount when the inZonaMetropolitana changes', (done) => {
			vm.store.address_in_zmvm = true
			Vue.nextTick(() => {
				expect(cart.order_total).toEqual(700);
				done()
			})
		})

		describe('Discounts', () => {
			it('applies a discount code of type "porcentaje_descuento"', (done) => {
				expect(cart.order_total).toEqual(1000);
				expect(cart.balance_to_be_transfered).toEqual(0);
				
				vm.store.discount = {
					type: 'porcentaje_descuento',
					value: 50
				}

				Vue.nextTick(() => {
					expect(cart.order_total).toEqual(500);
					expect(cart.balance_to_be_transfered).toEqual(500);
					done()
				})
			})

			it('applies a discount code of type "credito"', (done) => {
				expect(cart.order_total).toEqual(1000);
				expect(cart.balance_to_be_transfered).toEqual(0);
				
				vm.store.discount = {
					type: 'credito',
					value: 50
				}

				Vue.nextTick(() => {
					expect(cart.order_total).toEqual(950);
					expect(cart.balance_to_be_transfered).toEqual(50);
					done()
				})
			})

			it('applies a discount code of type "envio_gratis"', (done) => {
				expect(cart.order_total).toEqual(1000);
				expect(cart.balance_to_be_transfered).toEqual(0);
				
				vm.store.discount = {
					type: 'envio_gratis',
					value: 0
				}

				Vue.nextTick(() => {
					expect(cart.order_total).toEqual(500);
					expect(cart.balance_to_be_transfered).toEqual(500);
					done();
				})
			})

			it('changes the value of is_over_minimum if the order_total goes below the minimum because of a discount' , (done) => {
				expect(cart.is_over_minimum).toEqual(true);
				vm.store.discount = {
					type: 'envio_gratis',
					value: 0
				}

				Vue.nextTick(() => {
					expect(cart.is_over_minimum).toEqual(false);
					done();
				})
			})

			it('changes the value of balance_to_be_transfered  when discount is applied' , (done) => {
				expect(cart.balance_to_be_transfered).toEqual(0);
			
				vm.store.discount = {
					type: 'credito',
					value: 50
				}

				Vue.nextTick(() => {
					expect(cart.balance_to_be_transfered).toEqual(50);
					done();
				})
			})


		})
	})

	describe('shoppingBagForCheckout', () => {
		let vm = {}
		let cart = {}

		beforeEach(() => {
			let template = '<div></div>'
			
			const shoppingBagForCheckout = shoppingBagMaker(R.merge(normalCheckout, {template}))

			vm = new Vue({
				template: 
				`<div>
					<shopping-bag-for-checkout
						:exchange-rate="store.exchange_rate"
						:iva="store.iva"
						:is-shopping-bag="false"
						:balance="store.balance"
						:minimum="store.minimum"
						:in-zona-metropolitana="store.address_in_zmvm"
						:friendly-message-card="store.friendly_message_card"
						:bag-totals="store.bag_totals"
						:is-event="store.is_event_checkout"
						:discount-info="store.discount"
					></shopping-bag-for-checkout>
				</div>`,
				data: {
					store: {
						discount: {
							//spec
							//type: String //'percent', 'shipment', 'value'
							//value: Int
						},
						is_event_checkout: false,
						friendly_message_card_price: 200,
						friendly_message_card: false,
						exchange_rate: 1,
						iva: 16,
						balance: 1000,
						minimum: 800,
						fee_percentage: 5,
						address_in_zmvm: false,
						bag_totals: {
							price_with_discounts: 500,
							local_shipping_rate: 200,
							national_shipping_rate: 500
						},
						close_empty_bag: false,
					}
				},
				components: { shoppingBagForCheckout }
			}).$mount()
			
			cart = vm.$children[0]
		}) 

		
		it('separates iva, subtotal and shipping_costs and friendly_card_price from order_total', () => {
			expect(cart.order_total).toEqual(cart.iva_price + cart.subtotal + cart.shipping_costs + cart.friendly_card_price);
		})

		it('recalculates the correct amount when the inZonaMetropolitana changes', (done) => {
			expect(cart.order_total).toEqual(1000);
			vm.store.address_in_zmvm = true
			Vue.nextTick(() => {
				expect(cart.order_total).toEqual(700);
				done()
			})
		})

		it('recalculates the correct amount when the is_event_checkout changes', (done) => {
			expect(cart.order_total).toEqual(1000);
			vm.store.is_event_checkout = true
			Vue.nextTick(() => {
				expect(cart.order_total).toEqual(500);
				done()
			})
		})

		it('recalculates the correct amount when a friendly_card_message is selected and isEvent', (done) => {
			vm.store.friendly_message_card = true
			vm.store.is_event_checkout = true
			Vue.nextTick(() => {
				expect(cart.order_total).toEqual(700);
				done()
			})
		})

		describe('Discounts', () => {
			it('applies a discount code of type "porcentaje_descuento"', (done) => {
				expect(cart.order_total).toEqual(1000);
				
				vm.store.discount = {
					type: 'porcentaje_descuento',
					value: 50
				}

				Vue.nextTick(() => {
					expect(cart.order_total).toEqual(500);
					done()
				})
			})

			it('applies a discount code of type "credito"', (done) => {
				expect(cart.order_total).toEqual(1000);
				
				vm.store.discount = {
					type: 'credito',
					value: 50
				}

				Vue.nextTick(() => {
					expect(cart.order_total).toEqual(950);
					done()
				})
			})

			it('applies a discount code of type "envio_gratis"', (done) => {
				expect(cart.order_total).toEqual(1000);
				
				vm.store.discount = {
					type: 'envio_gratis',
					value: 0
				}

				Vue.nextTick(() => {
					expect(cart.order_total).toEqual(500);
					done();
				})
			})
		})
	})
})


