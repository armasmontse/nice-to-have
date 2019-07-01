@extends('layouts.event', ['body_id'	=> 	'main-vue'])

@section('title')
    | {{ $event->name }}
@endsection

@section('content')

    @include('client.events.web')

@endsection


@section('vue_store')
    <script>
        mainVueStore.event_date = {
            year: {{ $event->utc_date->year }},
            month: {{ $event->utc_date->month - 1  }}, //es 0 Index
            day:{{ $event->utc_date->day }},
            hour:{{ $event->utc_date->hour }},
            minutes: {{ $event->utc_date->minute }},
            gmt: undefined // fecha en utc
        }
    </script>
@endsection
