import {ifElementExistsThenLaunch, fixedSidebarWidth, positionX, cltvoEventsWarnings, documentClickHandlersLauncher} from './functions/dom';
import * as menu from './menus.js';
import {w} from './cltvo/constants.js';
import {fixedSideBarScroller} from './sidebar.js';
import {menuSelectedItem} from './menu-selected-item.js';
import {safeguardCollectionImagesHeights} from './safeguard-collection-images-heights';
import {alertsController} from './alerts-controller';
import {selectArrow} from './select-arrow';
import {filterMenuFixer} from './filter-menu-fixer';
import {scrollUp} from './scroll-up';
import {$faqToggle} from './$faq-toggle';
import {faqToggleOptions} from './theme-functions';

//Vue///
//==components
import {menuMobile} from './vue/components/menu-mobile';
import {userCards} from './vue/components/simple-cruds';
import {countDownTimer} from './vue/components/count-down-timer';
import  './vue/components/cltvo-editor';
import {infoSection} from './vue/components/info-section';
import {singleProduct} from './vue/components/single-product';
import {singleProductInfo} from './vue/components/single-product-info';
import {shopProduct} from './vue/components/shop-product';
import {userAccountMenu} from './vue/components/user-account-menu';
import {
	shoppingBagMenu, 
	shoppingBagWithPrices, 
	shoppingBagForCheckout, 
	shoppingBagWithPricesForEvent, 
	shoppingBagForEventCheckout
} from './vue/components/shopping-bags';

//==main
import {checkout} from './vue/main/checkout';
import {invoice} from './vue/main/invoice';
import {mainVue} from './vue/main-vue';
import {shop} from './vue/main/shop';
import {createEvent} from './vue/main/create-event';
import {updateEvent} from './vue/main/update-event';
import {eventsCart} from './vue/main/events-cart';
import {webTemplate} from './vue/main/web-template';
import {front} from './vue/main/front';
import {user} from './vue/main/user';


$(document).ready(function () {
	documentClickHandlersLauncher();

	//Desactiva scroll de mapa de evento
	$('.map_JS').addClass('event__scrolloff');
        $('.canvas_JS').on('click', function () {
            $('.map_JS').removeClass('event__scrolloff');
        });

	$('.map_JS').mouseleave(function () {
	   $('.map_JS').addClass('event__scrolloff');
   });

	//Flip arrow of selects in Tienda
	$('body').on('click','.toplevel_JS',function () {
		$(this).children('svg').toggleClass('flip');
	});


/**
 * Esta función regista cualquier otra función que requiera la existencia de ciertos elementos en el DOM y permite invocarla solo cuando esos elementos existen.
 *
 * Su principal objetivo es prevenir los errores de tipo:
 * 		"Uncaught TypeError: Cannot read property [x] of undefined"
 *
 * Recibe un array con los siguientes parámetros
 *@param 'string' DOM Node
 *@param 'Object' The "this" Context
 *@param 'method or function'
 *@param 'array' The functions parameters
 *
 * IMPORTANTE: De momento solo acepta un único elemento del DOM, como primer parámetro, pero la función invocada puede requerir de otros nodos. En un futuro debería aceptar un array con todas las dependencias de estas funciones.
 */

	ifElementExistsThenLaunch ([
		['#grid__fixedElem_JS', 'fixedSidebarWidth', undefined, ['#grid__fixedElem_JS']],
		['.menuTop__menuLang', 'positionX', undefined, ['.menuTop__menuLang', '#menuMain', -50]],
		['#menuMain', menu.main, 'init', ['menuMain']],
		['#menuMain',menu.main, 'fixMenu', [] ],
		['#menuMain', menu.mobile, 'init', ['menuResponsive']],
		['.submenu__link_JS', menuSelectedItem, undefined, ['.submenu__link_JS']],
		['#grid__fixedElem_JS', fixedSideBarScroller, undefined ,[]],
		['#alerts__container', alertsController, 'init', []],
		['#shop-filters', filterMenuFixer, undefined, ['#shop-filters']],
		['.icon__scroll-up_JS', scrollUp, undefined, ['.icon__scroll-up_JS']],
		['.faq_section_JS', $faqToggle, undefined, ['.faq_section_JS', faqToggleOptions]],

		//Vue's
		['#main-vue', mainVue, undefined, [front, {shopProduct,singleProduct, shoppingBagMenu, userAccountMenu, shoppingBagWithPrices, userCards, countDownTimer, infoSection, menuMobile}]],
		['#create-event-vue', mainVue, undefined, [createEvent, {shopProduct,singleProduct, shoppingBagMenu, userAccountMenu, shoppingBagWithPrices, menuMobile}]],
		['#update-event-vue', mainVue, undefined, [updateEvent, {shopProduct,singleProduct, shopProduct,singleProduct, shoppingBagMenu, userAccountMenu, menuMobile, shoppingBagForEventCheckout, shoppingBagWithPrices}]],
		['#checkout-event-vue', mainVue, undefined, [checkout, {shopProduct,singleProduct, shopProduct,singleProduct, shoppingBagMenu, userAccountMenu, menuMobile, shoppingBagForEventCheckout, shoppingBagWithPricesForEvent}]],
		['#web-template-vue', mainVue, undefined, [webTemplate, {shopProduct,singleProduct, shopProduct,singleProduct, shoppingBagMenu, userAccountMenu, shoppingBagWithPrices, menuMobile}]],
		['#single-vue', mainVue, undefined, [front, {singleProduct, shopProduct, infoSection, singleProductInfo, shoppingBagMenu, userAccountMenu, menuMobile}]],
		['#user-vue', mainVue, undefined, [user, {singleProduct, singleProductInfo, shoppingBagMenu, userAccountMenu, menuMobile}]],
		['#shop-vue', mainVue, undefined, [shop, {singleProduct, shopProduct, shoppingBagMenu, userAccountMenu, menuMobile}]],
		['#checkout-vue', mainVue, undefined, [checkout, {singleProduct, singleProductInfo, userAccountMenu, shoppingBagMenu, shoppingBagWithPrices, menuMobile, shoppingBagForCheckout}]],
		['#invoice-vue', mainVue, undefined, [invoice, {userAccountMenu, shoppingBagMenu, menuMobile}]],
	]);
});

w.on('load', function() {
	safeguardCollectionImagesHeights('.relatedProducts__slider-box');
	safeguardCollectionImagesHeights('.mediaCollection__container');
	setTimeout(cltvoEventsWarnings, 5000);
});

w.on('resize', function() {
	safeguardCollectionImagesHeights('.relatedProducts__slider-img');
	safeguardCollectionImagesHeights('.mediaCollection__container');
});
