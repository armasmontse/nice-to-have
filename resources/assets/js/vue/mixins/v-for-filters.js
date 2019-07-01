import _ from 'ramda';
import {alphabeticalObjSort, toArray} from '../../functions/pure';

export var vForFilters = {
	filters: {
		reverse(array) {
			return _.reverse(array);
		},

		/**
		 *
		 * Sorts alphabetically ignoring case.
		 *
		 * This function requires that additional arguments be passed to the function,
		 * this arguments are strings that are the properties by wich the desired property
		 * is acceseed in the object...
		 *
		 * @example: For list.es.name = v-for="color in list | alphabeticalObjSort 'es' 'name' "
		 *
		 * @param  {[array]} array [description]
		 * @param  {[array]} path additional arguments acceessed through the 'arguments' object
		 * @return {[array]}     Sorted by abc
		 */
		alphabeticalObjSort(array) {
			var path = toArray(arguments).slice(1);
			return alphabeticalObjSort(path)(array);
		},
	}
};

