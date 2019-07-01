import R from 'ramda';// Se usa R.compose para algunas pruebas
import {
	dateDifferenceInSeconds,
	fromSecondsToDaysHrsMinsSecs,
	countDown,
	normalizeHourByGMTOffset
} from '../functions/time';

describe('Dates function library', () => {

	it('[dateDifferenceInSeconds], recieves two dates and returns their absolute difference in seconds', () => {
		let date1 = new Date(2016, 9, 31, 13, 30);// 31 de Octubre a las 13:30
		let date2 = new Date(2016, 9, 31, 13, 31);// 31 de Octubre a las 13:30
		
		let difference = dateDifferenceInSeconds(date1, date2);
		let difference_inverted= dateDifferenceInSeconds(date2, date1);

		expect(difference).toBe(60);
		expect(difference_inverted).toBe(60);

	});

	it('[fromSecondsToDaysHrsMinsSecs], recieves a number of seconds and returns an object of type "{days, hours, minutes, seconds}"', () => {
		let date1 = new Date(2016, 9, 31, 13, 0, 0);// 31 de Octubre a las 13:30:30
		let date2 = new Date(2016, 10, 1, 14, 30, 30);// 1 de Noviembre a las 13:00:00
		let time_obj_spec = {
			days: 1,
			hours: 1,
			minutes: 30,
			seconds: 30
		};

		let time_obj = R.compose(fromSecondsToDaysHrsMinsSecs, dateDifferenceInSeconds)(date1, date2);
		expect(time_obj).toEqual(time_obj_spec);
		
	});

	it('[countDown & rectifyCountdown], [countDown] recieves an object of type "{days, hours, minutes, seconds}" and returns the same object minus one second. It uses [rectifyCountdown] under the hood to validate times and change minutes, hours or days when appropiate', () => {
		let total_time = {
			days: 1,
			hours: 1,
			minutes: 30,
			seconds: 30
		};

		//test 1: standard second substraction
		let countdown_spec_1 = {
			days: 1,
			hours: 1,
			minutes: 30,
			seconds: 29
		};

		let counted_down_1 = countDown(total_time);
		expect(counted_down_1).toEqual(countdown_spec_1);

		//test 2: if second is -1 then seconds = 0 and minutes = minutes - 1
		let total_time_2 = {
			days: 1,
			hours: 1,
			minutes: 30,
			seconds: 0
		};

		let countdown_spec_2 = {
			days: 1,
			hours: 1,
			minutes: 29,
			seconds: 59
		};

		let countdown_2 = countDown(total_time_2);
		expect(countdown_2).toEqual(countdown_spec_2);

		//test 3: if second is -1 and minutes is 0 then seconds = 59, minutes = 59 and hours = hours -1
		let total_time_3 = {
			days: 1,
			hours: 1,
			minutes: 0,
			seconds: 0
		};

		let countdown_spec_3 = {
			days: 1,
			hours: 0,
			minutes: 59,
			seconds: 59
		};

		let countdown_3 = countDown(total_time_3);
		expect(countdown_3).toEqual(countdown_spec_3);

		//test 4: if second is -1 and minutes is 0 and hours is 0 then seconds = 59, minutes = 59, hours = 23 and days = days -1
		let total_time_4 = {
			days: 1,
			hours: 0,
			minutes: 0,
			seconds: 0
		};

		let countdown_spec_4 = {
			days: 0,
			hours: 23,
			minutes: 59,
			seconds: 59
		};

		let countdown_4 = countDown(total_time_4);
		expect(countdown_4).toEqual(countdown_spec_4);

		//test 5: if second is -1 and minutes is 0 and hours is 0 and days is 0 then seconds = 0, minutes = 0, hours = 0 and days = 0
		let total_time_5 = {
			days: 0,
			hours: 0,
			minutes: 0,
			seconds: 0
		};

		let countdown_spec_5 = {
			days: 0,
			hours: 0,
			minutes: 0,
			seconds: 0
		};

		let countdown_5 = countDown(total_time_5);
		expect(countdown_5).toEqual(countdown_spec_5);

		// test 6: the input object is not transformed
		expect(countdown_4).not.toEqual(total_time_4);
	});

});