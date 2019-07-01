@extends('layouts.client', ['body_id'	=> 	'main-vue', 'body_class' => 'splash__body'])

@section('title')
	| Home
@endsection

@section('content')
	@include('client.pages._sections', ['page' => $main_page ])
@endsection
