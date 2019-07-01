@extends('layouts.client')

@section('title')
	{{$public_page->label}} |
@endsection

@section('content')
	@include('client.pages._sections', ['page' => $public_page ])
@endsection
