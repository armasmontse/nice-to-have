<count-down-timer :event-date="store.event_date"></count-down-timer>
<script type="x/templates" id="count-down-timer-template">
    <p class="event__countdown">@{{timer.days +' días - ' + timer.hours + ' horas - ' + timer.minutes +' minutos'}}</p>
</script>
