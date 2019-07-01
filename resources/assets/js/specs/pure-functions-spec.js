import R from 'ramda';// Se usa R.compose para algunas pruebas
import {
    pairWith,
    additiveFilter,
    rangeFilter,
    objTextFilter,
    isNumber,
    inString,
    alphabeticalObjSort,
    numericalObjSort,
    sortingOrder,
    idsByParentIds,
    objsById,
    pairObjToIdProp,
    nestedPropToUpperLevel,
    doubleMapNestedAndReturnInUpperLevel,
    sumTotal,
    sumTotalPrice,
    validateEmail,
    fieldValidator,
    meridianHoursByInterval,
    realHoursByInterval,
    realAndMeridianHoursByInterval
} from '../functions/pure';

process.env.NODE_ENV='';//'dev' shows errors related to the logAndReturnSomething function

describe('Pure function library', () => {

   it('[pairWith] should create an array of two elements paired from two properties extracted from another object', () => {
      var obj = {color: 'blue', color_id: 1, something: 'else'};
      var color_by_id= pairWith('color_id', 'color', obj);
      expect(color_by_id).toEqual([1, 'blue']);
   });

    it('[additiveFilter] a curryable/composable function that takes a categories array and array of categorizable objects and returns an array of the categorizable objects that have the selected categories. If the categories array is empty, the whole array of categorizable objects should be returned', () => {
    	expect(additiveFilter).toBeDefined();
    	let categorizable_objs = [
    		{with_a:'x', categories:['a'], another_category:['cool']},
    		{with_b:'x', categories:['b'], another_category:[]},
    		{with_n:'x', categories:['n'], another_category:['nice']},
    		{with_a_b:'x', categories:['a', 'b'], another_category:[]},
    		{with_c_d:'x', categories:['c', 'd'], another_category:['asparragus']}
    	];

    	//Test 1
    	let A_cat  = ['a'];
    	let fitered_A_s = [
            {with_a:'x', categories:['a'], another_category:['cool']},
            {with_a_b:'x', categories:['a', 'b'], another_category:[]},
    	];
    	let A_s = additiveFilter(['categories'], A_cat, categorizable_objs);
		expect(A_s).toEqual(fitered_A_s);

    	//Test 2
    	let A_B_cat  = ['a', 'b'];
		let filtered_A_B_s = [
            {with_a:'x', categories:['a'], another_category:['cool']},
            {with_b:'x', categories:['b'], another_category:[]},
            {with_a_b:'x', categories:['a', 'b'], another_category:[]},
    	];
    	let A_B_s = additiveFilter(['categories'], A_B_cat, categorizable_objs);
		expect(A_B_s).toEqual(filtered_A_B_s);

        //Test 3 Curry
        let A_C_D_cat  = ['a', 'c', 'd'];
        let filtered_A_C_D_s = [
            {with_a:'x', categories:['a'], another_category:['cool']},
            {with_a_b:'x', categories:['a', 'b'], another_category:[]},
            {with_c_d:'x', categories:['c', 'd'], another_category:['asparragus']}
        ];
        let A_C_D_s = additiveFilter(['categories'], A_C_D_cat)(categorizable_objs);
        expect(A_C_D_s).toEqual(filtered_A_C_D_s);

        //Test 3.1 Chaining filters
        let Asparragus_cat  = ['asparragus', 'cool'];
        let filtered_A_C_s = [
            {with_a:'x', categories:['a'], another_category:['cool']},
            {with_c_d:'x', categories:['c', 'd'], another_category:['asparragus']}
        ];

        let A_C_s = R.compose(additiveFilter(['another_category'], Asparragus_cat), additiveFilter(['categories'], A_C_D_cat))(categorizable_objs);
        expect(A_C_s).toEqual(filtered_A_C_s);

        //Test 4: empty array
        let empty_cat  = [];

        let all = additiveFilter(['categories'], empty_cat, categorizable_objs);
        expect(all).toEqual(categorizable_objs);
   	});

    it('[rangeFilter] is a curryable/composable function that looks at a property to filter/compare-against, an array with a numerical range and array of filterable objects that must include the specified property. It returns an array of the filterable objects that are withing the specified range. If the range is inverted or if no filter_prop exists it returns the filterable_objs array unfiltered', () => {
        let priced_objs = [
            {with_a:'x', categories:['a'], another_category:['cool'], price:20},
            {with_b:'x', categories:['b'], another_category:[], price:30},
            {with_n:'x', categories:['n'], another_category:['nice'], price:40},
            {with_a_b:'x', categories:['a', 'b'], another_category:[], price:50},
            {with_c_d:'x', categories:['c', 'd'], another_category:['asparragus'], price:60}
        ];

        //Test 1 - Returns filterable obj when filter_prop is missing
        let non_filterable = [{halo: 'welt'}];
        let halo_welt = rangeFilter(['price'], [0,100], non_filterable);
        expect(halo_welt).toEqual(non_filterable);

        //Test 2 - Returns filterable obj_array when pricerange is inverted
        let inverted_range = rangeFilter(['price'], [50, 0], priced_objs);
        expect(inverted_range).toEqual(priced_objs);

        //Test 2.1 - Returns filterable obj_array when pricerange is  incomplete
        let incomplete_range = rangeFilter(['price'], [50], priced_objs);
        expect(incomplete_range).toEqual(priced_objs);

        //Test 2.2 - Returns filterable obj_array when pricerange has one field is an empty string or a string that is not parseable or null or undefined
        let empty_string_range_a = rangeFilter(['price'], ['', 0], priced_objs);
        expect(empty_string_range_a).toEqual(priced_objs);
        let empty_string_range_b = rangeFilter(['price'], [0, ''], priced_objs);
        expect(empty_string_range_b).toEqual(priced_objs);

        let empty_string_range_null_a = rangeFilter(['price'], [null, 0], priced_objs);
        expect(empty_string_range_null_a).toEqual(priced_objs);

        let empty_string_range_undefined = rangeFilter(['price'], [undefined, 0], priced_objs);
        expect(empty_string_range_undefined).toEqual(priced_objs);

        //Test 2.3 - Returns filterable obj_array when both ends of the price range are 0
        let _0_0 = rangeFilter(['price'], [0, 0], priced_objs);
        expect(_0_0).toEqual(priced_objs);

        //Test 3 - Proper Filtering
        let from_40_to_100s = [
            {with_n:'x', categories:['n'], another_category:['nice'], price:40},
            {with_a_b:'x', categories:['a', 'b'], another_category:[], price:50},
            {with_c_d:'x', categories:['c', 'd'], another_category:['asparragus'], price:60}
        ];
        let from_40_to_100 = rangeFilter(['price'], [40, 60], priced_objs);
        expect(from_40_to_100).toEqual(from_40_to_100s);

        //Test 4 - Takes infinity values
        let from_40_to_infinity_s = [
            {with_n:'x', categories:['n'], another_category:['nice'], price:40},
            {with_a_b:'x', categories:['a', 'b'], another_category:[], price:50},
            {with_c_d:'x', categories:['c', 'd'], another_category:['asparragus'], price:60}
        ];
        let from_40_to_infinity = rangeFilter(['price'], [40, Infinity], priced_objs);
        expect(from_40_to_infinity).toEqual(from_40_to_infinity_s);

            //
        let from_minus_infinity_to_infinity_s = [
            {with_a:'x', categories:['a'], another_category:['cool'], price:20},
            {with_b:'x', categories:['b'], another_category:[], price:30},
            {with_n:'x', categories:['n'], another_category:['nice'], price:40},
            {with_a_b:'x', categories:['a', 'b'], another_category:[], price:50},
            {with_c_d:'x', categories:['c', 'd'], another_category:['asparragus'], price:60}
        ];
        let from_minus_infinity_to_infinity = rangeFilter(['price'], [-Infinity, Infinity], priced_objs);
        expect(from_minus_infinity_to_infinity).toEqual(from_minus_infinity_to_infinity_s);

            //
         let from_minus_infinity_to_40_s = [
            {with_a:'x', categories:['a'], another_category:['cool'], price:20},
            {with_b:'x', categories:['b'], another_category:[], price:30},
            {with_n:'x', categories:['n'], another_category:['nice'], price:40},
        ];

        let from_minus_infinity_to_40 = rangeFilter(['price'], [-Infinity, 40], priced_objs);
        expect(from_minus_infinity_to_40).toEqual(from_minus_infinity_to_40_s);

        //Test 5 - Takes the same value in both extremes of the range
         let from_40_to_40_s = [
            {with_n:'x', categories:['n'], another_category:['nice'], price:40},
        ];

        let from_40_to_40 = rangeFilter(['price'], [40, 40], priced_objs);
        expect(from_40_to_40).toEqual(from_40_to_40_s);

        //Test 6 - It can be composed with itself
        let composed_with_itself = R.compose(rangeFilter(['price'], [40, 40]), rangeFilter(['price'], [-Infinity, 40]))(priced_objs);
        expect(composed_with_itself).toEqual(from_40_to_40_s);

        //Test 6.1 - It can be composed with other filters
        let Asparragus_cat  = ['asparragus', 'cool'];
        let just_cool = [
             {with_a:'x', categories:['a'], another_category:['cool'], price:20},
        ];
        let composed_with_others = R.compose(rangeFilter(['price'], [0, 40]), additiveFilter(['another_category'], Asparragus_cat))(priced_objs);
        expect(composed_with_others).toEqual(just_cool);
    });

    it('[objTextFilter] tests and obj for containing a certain string. It is a curryable/composable function takes a filter_prop_path a string for comparing and a filterable_objs array and returns an array of filtered obj', () => {
        let objs = [
        {title: 'blues'},
        {title: 'rock'},
        {title: 'experimental'},
        {title: 'baroque'},
        {title: 'punk rock'},
        ];

        let unfiltered = objTextFilter(['title'], '')(objs)
        expect(unfiltered).toEqual(objs);

        let by_r_s =  [
        {title: 'rock'},
        {title: 'experimental'},
        {title: 'baroque'},
        {title: 'punk rock'},
        ];

        let r_s = objTextFilter(['title'], 'r')(objs)
        expect(r_s).toEqual(by_r_s);
    });

    it('[inString] turns a test_string in to a RegExp and tests if the other string matches the RegExp. Returns a Boolean value, and is curryable', () => {
        let s = 'experimental';

        let has_ex = inString('ex', s);
        expect(has_ex).toEqual(true);

        let has_men = inString('men', s);
        expect(has_men).toEqual(true);

        let has_false = inString('false', s);
        expect(has_false).toEqual(false);

        //Curryable
        let has_al = inString('al')(s)
        expect(has_al).toEqual(true);
    });

    it('[alphabeticalObjSort], sorts alphabetically ignoring case. Takes a ramda path_arr. Is curryable/composable', () => {
        let  obj = [
            {   prop: 'dalga', nested: { prop: 'halga' } },
            {   prop: 'falga', nested: { prop: 'galga' } },
            {   prop: 'alga', nested: { prop: 'balga' } },
            {   prop: 'calga', nested: { prop: 'lalga' } }
        ];

        //does not sort
        let no_prop_s = alphabeticalObjSort([])(obj);
        expect(no_prop_s).toEqual(obj);

        let stringed_prop_s = alphabeticalObjSort('prop')(obj);
        expect(stringed_prop_s).toEqual(obj);


        //sorts prop
        let sorted_prop_s = [
            {   prop: 'alga', nested: { prop: 'balga' } },
            {   prop: 'calga', nested: { prop: 'lalga' } },
            {   prop: 'dalga', nested: { prop: 'halga' } },
            {   prop: 'falga', nested: { prop: 'galga' } }
        ];
        let sorted_prop = alphabeticalObjSort(['prop'])(obj)
        expect(sorted_prop_s).toEqual(sorted_prop);

        //sorts nested prop
        let nested_sorted_prop_s = [
            {   prop: 'alga', nested: { prop: 'balga' } },
            {   prop: 'falga', nested: { prop: 'galga' } },
            {   prop: 'dalga', nested: { prop: 'halga' } },
            {   prop: 'calga', nested: { prop: 'lalga' } }
        ];
        let nested_sorted_prop = alphabeticalObjSort(['nested', 'prop'])(obj)
        expect(nested_sorted_prop_s).toEqual(nested_sorted_prop);
    });

    it('[numericalObjSort], sorts an array of objects by a property that contains a number. The property might be nested and shoudl be declared as a path in an array (Ramda style)', () => {
        let numbers= [
            {prop: 57},
            {prop: 200},
            {prop: 56},
            {prop: 67}
        ];
        let sorted_numbers_asc= [
            {prop: 56},
            {prop: 57},
            {prop: 67},
            {prop: 200}
        ];
        let number_sort_asc = numericalObjSort(['prop'], 'asc')(numbers)
        expect(number_sort_asc).toEqual(sorted_numbers_asc);

        let sorted_numbers_desc= [
            {prop: 200},
            {prop: 67},
            {prop: 57},
            {prop: 56}
        ];
        let number_sort_desc = numericalObjSort(['prop'], 'desc')(numbers)
        expect(number_sort_desc).toEqual(sorted_numbers_desc);

        //bad prop 
         let number_sort_bad = numericalObjSort(['bad_prop'], 'desc')(numbers)
        expect(number_sort_bad).toEqual(numbers);  
    });

    it('[sortingOrder], Allows toggling between a ascending order(default) and an descending order for an array. "asc" for ascending, "desc" for descending. For its proper functioning it should be used after the sorting of an array. It is a wrapper on R.reverse', () => {
        let letters= [
            'a',
            'b',
            'c',
            'd',
        ];
        //Descending
        let letters_desc_s = [
            'd',
            'c',
            'b',
            'a',
        ]
        let letters_desc = sortingOrder('desc')(letters)
        expect(letters_desc).toEqual(letters_desc_s);
        //Ascending
        let letters_asc = sortingOrder('asc')(letters)
        expect(letters_asc).toEqual(letters);

    });

    it('[idsByParentIds] conviniently extracts ids and parents ids from an array of objects and returns an array with parent_ids as keys whose value is a array of the related ids', () => {
            let subcategories = [
            {
                id:1,
                category_id: 1
            },
            {
                id:2,
                category_id: 1
            },
            {
                id:3,
                category_id: 3
            },
            {
                id:4,
                category_id: 2
            }
        ];
        let subcats_by_cat_id  = idsByParentIds('category_id', 'id', subcategories)
        expect(subcats_by_cat_id).toEqual({1:[1, 2], 2:[4], 3:[3]})
    });

    it('[pairObjToIdProp] pairs an object to an id_prop extracted from it', () => {
        let cat = {
            id: 1,
            name: 'meow'
        };
        let cat_by_id = pairObjToIdProp('id', cat)
        expect(cat_by_id).toEqual([1, cat])

    });

    it('[objsById]extracts id prop from objs in an array and returns an object with the id_prop as key and the source object as value', () => {
        let subcategories = [
            {
                id:1,
                category_id: 1
            },
            {
                id:2,
                category_id: 1
            },
            {
                id:3,
                category_id: 3
            },
            {
                id:4,
                category_id: 2
            }
        ];
        let subcats_by_id  = objsById('id', subcategories);

        let objsById_spec = {
            1:  {
                id:1,
                category_id: 1
            },
             2: {
                id:2,
                category_id: 1
            },
            3:  {
                id:3,
                category_id: 3
            },
            4: {
                id:4,
                category_id: 2
            }
        }
        expect(subcats_by_id).toEqual(objsById_spec)
    });

    it('[nestedPropToUpperLevel] toma una propiedad anidada y regresa una copia del objeto con la propiedad en el primer nivel del mismo, si otra propiedad ya existe con el mismo nombre, será sobre escrita', () => {
        let spec = {
            prop: 'hola',
            nested: {
                property: [1,2,3,4,5]
            }
        };

        //test 1 Unnesting
        let unnested_spec = {
            prop: 'hola',
            property: [1,2,3,4,5],
            nested: {
                property: [1,2,3,4,5]
            }
        };
        let unnested = nestedPropToUpperLevel(['nested', 'property'], 'property', spec);
        expect(unnested).toEqual(unnested_spec);

        //test 2 Spec is not modified
        let spec_control = {//igual que spec
            prop: 'hola',
            nested: {
                property: [1,2,3,4,5]
            }
        };
        expect(spec_control).toEqual(spec);
    });

    it('[doubleMapNestedAndReturnInUpperLevel] Recibe un array de objetos con una propiedad que unsegundo array a mappear. Regresa una copia del objeto con la propiedad en el primer nivel del mismo, si otra propiedad ya existe con el mismo nombre, será sobre escrita.', () => {
        //[paths] -> [paths] -> String -> [{prop: nested_target:[{finaltarget:'value'}]}] -> [{String:[mapped_values]}]
        let spec = [
            {
                nested: {
                    target: [{id: 1}, {id:2}]
                }
            },
            {
                nested: {
                    target: [{id: 1}, {id:3}]
                }
            }
        ];

        let unnested_and_mapped = doubleMapNestedAndReturnInUpperLevel(['nested', 'target'], ['id'], 'target_ids',spec);
        let unnested_and_mapped_spec = [
            {
                target_ids:[1,2],
                nested: {
                    target: [{id: 1}, {id:2}]
                }
            },
            {
                target_ids:[1,3],
                nested: {
                    target: [{id: 1}, {id:3}]
                }
            }
        ];
        expect(unnested_and_mapped).toEqual(unnested_and_mapped_spec);

        let empty_spec = doubleMapNestedAndReturnInUpperLevel(['nested', 'target'], ['id'], 'target_ids',[]);
        expect(empty_spec).toEqual([]);

        let undefined_spec = doubleMapNestedAndReturnInUpperLevel(['nested', 'target'], ['id'], 'target_ids',undefined);
        expect(undefined_spec).toEqual([]);
    })

     it('[sumTotal] Takes a numerical prop i.e. price, a quantity prop an array of objects with price and quantity props and returns the total', () => {
        let total = sumTotal('quantity', 'price')([{quantity: 1, price:10}, {quantity: 2, price: 5}]);
        expect(total).toBe(20);

        let total_2 = sumTotal('quantity', 'price')([{quantity: 1, price:10}, {price: 5}]);
        expect(total_2).toBe(15);
    });

    it('[sumTotalPrice] Takes an array of objects with price and quantity props and returns the total', () => {
        let total = sumTotalPrice([{quantity: 1, price:10}, {quantity:2, price: 5}]);
        expect(total).toBe(20);
    });

    it('[validateEmail] Tests if a string is a valid email', () => {
        let email = validateEmail('diego@diego.com');
        expect(email).toBe(true);
        
        
        //debe contener un TLD
        let no_email1 = validateEmail('diego@aksdj');
        expect(no_email1).toBe(false);
        
        //el TLD debe ser mayor a un sólo caracter
        let no_email2 = validateEmail('diego@bla.c');
        expect(no_email2).toBe(false);
        
        //debe contener una arroba
        let no_email3 = validateEmail('diego.com');
        expect(no_email3).toBe(false);
    });

     it('[fieldValidator] Tests if all the fields of an object are no empty, and returns an array of messages for each field that is not present', () => {
        let messages = {
            event_name: 'El nombre del evento no puede estar vacío',
            event_people: 'Tienes que indicar por lo menos un festejado',
            event_date: 'La fecha del evento tiene que estar definida'
        }

        let invalid1 = {
            event_name: '',
            event_people: '',
            event_date: ''
        }

        expect(fieldValidator(invalid1, messages)).toEqual(R.values(messages))

     });




       it('[meridianHoursByInterval] :: [String intervals]  -> [String meridian_hours_by_interval]', () => {
            expect(meridianHoursByInterval(["00", "30"])).toEqual(R.values(["00:00 AM", "00:30 AM", "01:00 AM", "01:30 AM", "02:00 AM", "02:30 AM", "03:00 AM", "03:30 AM", "04:00 AM", "04:30 AM", "05:00 AM", "05:30 AM", "06:00 AM", "06:30 AM", "07:00 AM", "07:30 AM", "08:00 AM", "08:30 AM", "09:00 AM", "09:30 AM", "10:00 AM", "10:30 AM", "11:00 AM", "11:30 AM", "00:00 PM", "00:30 PM", "01:00 PM", "01:30 PM", "02:00 PM", "02:30 PM", "03:00 PM", "03:30 PM", "04:00 PM", "04:30 PM", "05:00 PM", "05:30 PM", "06:00 PM", "06:30 PM", "07:00 PM", "07:30 PM", "08:00 PM", "08:30 PM", "09:00 PM", "09:30 PM", "10:00 PM", "10:30 PM", "11:00 PM", "11:30 PM"]))
        });

       it('[realHoursByInterval] :: [String intervals]  -> [String hours_by_interval]', () => {
            expect(realHoursByInterval(["00", "30"])).toEqual(R.values([ '00:00', '00:30', '01:00', '01:30', '02:00', '02:30', '03:00', '03:30', '04:00', '04:30', '05:00', '05:30', '06:00', '06:30', '07:00', '07:30', '08:00', '08:30', '09:00', '09:30', '10:00', '10:30', '11:00', '11:30', '12:00', '12:30', '13:00', '13:30', '14:00', '14:30', '15:00', '15:30', '16:00', '16:30', '17:00', '17:30', '18:00', '18:30', '19:00', '19:30', '20:00', '20:30', '21:00', '21:30', '22:00', '22:30', '23:00', '23:30' ]))
        });

       it('[realAndMeridianHoursByInterval] :: [String intervals]  -> [[String real_hour, String meridian_hour]]', () => {
            expect(realAndMeridianHoursByInterval(["00", "30"])[5]).toEqual(['02:30', '02:30 AM'])
            expect(realAndMeridianHoursByInterval(["00", "30"])[8]).toEqual([ '04:00', '04:00 AM' ])
            expect(realAndMeridianHoursByInterval(["00", "30"])[40]).toEqual([ '20:00', '08:00 PM' ]) 
        });


});
