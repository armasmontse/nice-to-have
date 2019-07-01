import R from 'ramda';
import {doubleMapNestedAndReturnInUpperLevel} from '../../functions/pure';

//bagWithSkusArray :: SomeBagProducts [{skus:{sku}, *}] -> [{skus_array, *}]
const bagWithSkusArray = doubleMapNestedAndReturnInUpperLevel(['skus'], ['sku'], 'skus_array')

//printableBagIndex :: SomeBagProducts [{skus:{sku}, *}] -> Integer
const printableBagIndex = function(ctx, bag) { return R.pathOr(-1, ['printableBagIndexByPrintableBagSlug', bag], ctx);}

//skusWithQuantityOfCurrentBag :: PrintableBag [{skus:quantity}] -> [{sku, quantity}]
const skusWithQuantityOfBag = R.compose(
	R.map( sku_quantity => ({ sku: sku_quantity[0], quantity: sku_quantity[1] }) ),
	R.toPairs
)

//hasSku :: 'sku' -> Bool
const hasSku = sku => R.compose(R.contains(sku), R.prop('skus_array'));

//getProduct :: [{sku, quantity}] -> [{*, [skus]}] -> {sku}
const getProduct = (skus_with_quantities, bag) => R.clone(
	R.find(
		hasSku(skus_with_quantities.sku), 
		bag
	)
)

//bagProductsWithSelectedSkusQuantitiesAndPrices :: [{sku, quantity}] -> [{*, [skus]}] ->  [{selected_sku, quantity, price, local_shipping_rate, national_shipping_rate,*}]
const bagProductsWithSelectedSkusQuantitiesAndPrices =(skus_with_quantities_of_bag, bag_products_with_skus_array) => 
	R.map(swq => {
		let product = getProduct(swq, bag_products_with_skus_array)
		if (!product) {return}
		let selected_sku_index = R.findIndex(R.propEq('sku', swq.sku), product.skus || {});
		let price = R.pathOr(NaN, ['skus', selected_sku_index, 'price_with_discount'], product);
		let local_shipping_rate = R.pathOr(NaN, ['skus', selected_sku_index, 'local_shipping_rate'], product);
		let national_shipping_rate = R.pathOr(NaN, ['skus', selected_sku_index, 'national_shipping_rate'], product);
		product.price = price;
		product.selected_sku = swq.sku;
		product.quantity = swq.quantity;
		product.local_shipping_rate = local_shipping_rate;
		product.national_shipping_rate = national_shipping_rate;
		return product;
	}, skus_with_quantities_of_bag
)


/*El mixin*/
export const shoppingBagDataAndComputedProps = {
	data () {
		return {
			bag_names: {
				'retirar-mesa-de-regalos' : {es: 'Retirar de mesa de regalos'},
				'agregar-a-mesa-de-regalos': {es: 'Para Mesa De Regalos'},
				personal: {es: 'Para Mi'},
				regalo: {es: 'Para Alguien'}
			},
		};
	},
	computed: {
		printableBagKeys() {
			return R.keys(this.store.bags)
		},
//Objeto importante
		//printableBags :: store.bags {bag: {*}} -> printableBagKeys [Int] -> bag_names [{Int:String}] -> [{*}]
		printableBags() {
			return R.map(key => {
				let bag = this.store.bags[key];
				bag.slug = key,
				bag.name = this.bag_names[key];
				return bag;
			}, this.printableBagKeys);
		},

		//totalItemsInBags :: printableBags [{total : Int, *}] -> Int
		totalItemsInBags() {
			return R.sum(R.pluck('total', this.printableBags));
		},

		//skusByPrintableBag :: printableBags [{skus: [{String sku : Int}]] -> [String sku]
		skusByPrintableBag() {
			return R.compose(R.map(R.keys), R.pluck('skus'))(this.printableBags);
		},

		//printableBagIndexByPrintableBagSlug :: printableBags [{slug}] -> {String slug : Index Int}
		printableBagIndexByPrintableBagSlug() {//se usa para relacionar los skus con los botones de agregar a la bolsa, en el template de single.vue.forms.shopping-bag
			let mapIndexed = R.addIndex(R.map);
			return R.compose(R.mergeAll, mapIndexed((slug, index) => ({[slug]: index})), R.pluck('slug'))(this.printableBags);
		},



/* 
========= Procesos para generar las bolsas en el carrito ==========
	
	(son casi un copy paste, una de la otra)
	
	Las funcionalidades del carrito dependen de mantener la interfaz que estas bolsas implican.
	Pues toman objetos del "store" y la actualización de los datos que se comunica al resto de 
	los componentes depende de esto.
	Estos objetos son store.current_bag y store.bags.
	store.bags específicamente debe tener siempre el mismo spec
	

	bags: {
		<nombre-de-la-bolsa>: {
			key: String,
			name:Object,
			skus: {
				PqidM2B2GMcqiiqiii:3
				PqidM2B2GMdteveskk:1
				PqidM2B2GMnvldehci:1
				//i.e.
				String: Int
			},
			slug:<nombre-de-la-bolsa>,
			total:5
		}
	}

	(el metodo que genera estas bolsas en el back está en el  "ClientController" y se llama "getBagsContent")
*/
		
	//Mesa de Regalos
		mesaBagProductsWithSkusArray(){
			return bagWithSkusArray(R.pathOr([], ['store','current_bags', 'agregar-a-mesa-de-regalos', 'bag', 'products'], this));
		},

		mesaPrintableBag(){
			return this.printableBags[printableBagIndex(this,  'agregar-a-mesa-de-regalos')] || {};
		},

		skusWithQuantityOfMesaBag(){
			return skusWithQuantityOfBag(R.pathOr([], ['mesaPrintableBag', 'skus'], this));
		},

			//resultado
		mesaBagProductsWithSelectedSkusQuantitiesAndPrices(){
			return bagProductsWithSelectedSkusQuantitiesAndPrices(
				this.skusWithQuantityOfMesaBag, 
				this.mesaBagProductsWithSkusArray
			)
		},

	//Personal
		personalBagProductsWithSkusArray(){
			return bagWithSkusArray(R.pathOr([], ['store','current_bags', 'personal', 'bag', 'products'], this));
		},

		personalPrintableBag(){
			return this.printableBags[printableBagIndex(this,  'personal')] || {};
		},

		skusWithQuantityOfPersonalBag(){
			return skusWithQuantityOfBag(R.pathOr([], ['personalPrintableBag', 'skus'], this));
		},

			//resultado
		personalBagProductsWithSelectedSkusQuantitiesAndPrices(){
			return bagProductsWithSelectedSkusQuantitiesAndPrices(
				this.skusWithQuantityOfPersonalBag, 
				this.personalBagProductsWithSkusArray
			);
		},
	//Evento
		eventBagProductsWithSkusArray(){
			return bagWithSkusArray(R.pathOr([], ['store', 'current_bag', 'bag', 'products'], this));
		},

		eventPrintableBag(){
			return this.printableBags[printableBagIndex(this,  'retirar-mesa-de-regalos')] || {};
		},


		skusWithQuantityOfEventBag(){
			return skusWithQuantityOfBag(R.pathOr([], ['eventPrintableBag', 'skus'], this));
		},

			//resultado
		eventBagProductsWithSelectedSkusQuantitiesAndPrices(){
			return bagProductsWithSelectedSkusQuantitiesAndPrices(
				this.skusWithQuantityOfEventBag, 
				this.eventBagProductsWithSkusArray
			)
		},
	}
};
