@extends('layouts.modal', ['modal_id' => 'myModal1'])

@section('title-modal')
    Modal title 1
@overwrite

@section('modal-content')
    <div class="row">
        <div class="col-xs-12">
            <span class="text__p">Modal Content 1</span>
        </div>
    </div>
@overwrite
