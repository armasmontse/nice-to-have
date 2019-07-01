@extends('layouts.page_section', ["section_index"=> "multiple-unlimited"])

@section('page_section-content')
    @include('admin.pages.contents.templates._components-create_form')
    @include('admin.pages.contents.templates._components-list')
    @include('admin.pages.contents.templates._components-sort_form')
@overwrite
