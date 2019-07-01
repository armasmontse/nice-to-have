import R from 'ramda';
import {numberFilters} from '../mixins/number-filters';
import {crudAjax} from '../mixins/crud-ajax';
import {shoppingBagDataAndComputedProps} from '../mixins/shopping-bags-data-and-computed-props';


export const eventsCart =  {
	el: 'body',
	mixins: [crudAjax, shoppingBagDataAndComputedProps, numberFilters]
};
