@extends('theme::default')

@section('title', @$rows->title)
@section('content')
  {!! \Wh::quickEdit('/admin/page/add-edit/pages/'.@$rows->id) !!}
 {!! @$content !!}

@stop