<count-down-timer :event-date="store.event_date"></count-down-timer>
<script type="x/templates" id="count-down-timer-template">
	<div class="event__countdown">
		<span class="event__countdown--item">
			<span class="event__countdown--item-number">@{{ timer.days }}</span>
			<span class="event__countdown--item-string">{{ trans('events.templates.timer_days') }}</span>
		</span>
		<span class="event__countdown--item">
			<span class="event__countdown--item-number">@{{ timer.hours }}</span>
			<span class="event__countdown--item-string">{{ trans('events.templates.timer_hours') }}</span>
		</span>
		<span class="event__countdown--item">
			<span class="event__countdown--item-number">@{{ timer.minutes }}</span>
			<span class="event__countdown--item-string">{{ trans('events.templates.timer_mins') }}</span>
   	</span>
	</div>
</script>
