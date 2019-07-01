@extends('layouts.client')

@section('title')
	{{$public_child_page->label}} | {{$public_page->label}} |
@endsection

@section('content')
	@include('client.pages._sections', ['page' => $public_child_page ])
@endsection
