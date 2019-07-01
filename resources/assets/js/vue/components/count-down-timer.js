import Vue from 'vue';
import {dateIsOverdue, dateDifferenceInSeconds, fromSecondsToDaysHrsMinsSecs, countDown} from '../../functions/time';

export const countDownTimer = Vue.extend({
	template: '#count-down-timer-template',
	props:['eventDate'],
	data() {
		return {
			timer:{
				days: 0,
				hours: 0,
				minutes: 0,
				seconds: 0
			},

			dateIsOverdue: false,
		}
	},

	ready() {
		let
			now = new Date(),
			nowUTC = new Date(now.getUTCFullYear(), now.getUTCMonth(), now.getUTCDate(), now.getUTCHours()),
			eventDate = new Date(this.eventDate.year, this.eventDate.month, this.eventDate.day, this.eventDate.hour, this.eventDate.minutes),
			intervalID;

		this.dateIsOverdue = dateIsOverdue(eventDate, nowUTC);

		if(!this.dateIsOverdue) {
			this.timer = fromSecondsToDaysHrsMinsSecs(dateDifferenceInSeconds(eventDate, nowUTC));
			intervalID = setInterval(() => {
				this.timer = countDown(this.timer);
				if (this.timer.days <= 0 && this.timer.hours <= 0 && this.timer.minutes <= 0 && this.timer.seconds <= 0) {
					clearInterval(intervalID);
					this.dateIsOverdue = true;
				}
			}, 1000);
		}
	}
});
