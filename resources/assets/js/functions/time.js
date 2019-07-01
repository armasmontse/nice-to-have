//dateDifferenceInSeconds :: Date -> Date -> Int
export const dateDifferenceInSeconds = (date1, date2) => Math.abs(date1 - date2)/1000;

//dateDifferenceInSecondsNotAbs :: Date -> Date -> Int
export const dateIsOverdue = (date1, date2) => (date1 - date2)/1000 < 0;

//fromSecondsToDaysHrsMinsSecs :: Int -> {days, hours, minutes, seconds}
export const fromSecondsToDaysHrsMinsSecs = seconds => {
	let one_day = 60*60*24;
	let one_hour= 60*60;
	let one_minute= 60;
	let time_obj = {};
	time_obj.days = Math.floor(seconds/one_day);
	time_obj.hours = Math.floor((seconds - (time_obj.days*one_day))/one_hour);
	time_obj.minutes = Math.floor((seconds - (time_obj.days*one_day) - (time_obj.hours*one_hour))/one_minute);
	time_obj.seconds = Math.floor((seconds - (time_obj.days*one_day) - (time_obj.hours*one_hour)- (time_obj.minutes*one_minute)));
	return time_obj;
};

//rectifyCountdown :: {days, hours, minutes, seconds} -> {days, hours, minutes, seconds}
//Prevents numbers from reaching -1 and adjusts accordingly
const rectifyCountdown = time_obj => {
	//el contador llegó a ceros
	if (time_obj.days === 0 && time_obj.hours === 0 && time_obj.minutes === 0 && time_obj.seconds >= -1) {
		time_obj.seconds = 0;
		return time_obj;
	}
	//el contador tiene un tiempo válido
	if (time_obj.days >= 0 && time_obj.hours >= 0 && time_obj.minutes >= 0 && time_obj.seconds >= 0) { return time_obj;}
	
	//algún valor del contador llegó a -1
	if (time_obj.seconds === -1) {
		time_obj.seconds = 59;
		time_obj.minutes = time_obj.minutes -1;
	}

	if (time_obj.minutes === -1) {
		time_obj.minutes = 59;
		time_obj.hours = time_obj.hours -1;
	}

	if (time_obj.hours === -1) {
		time_obj.hours = 23;
		time_obj.days = time_obj.days -1;
	}
	return time_obj;
};

//countDown :: {days, hours, minutes, seconds} -> {days, hours, minutes, seconds}
export const countDown = time_obj => { 
	return rectifyCountdown({
		days: time_obj.days,
		hours: time_obj.hours,
		minutes: time_obj.minutes,
		seconds: time_obj.seconds -1
	});
};