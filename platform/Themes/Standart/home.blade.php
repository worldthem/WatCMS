@extends('theme::default')

@section('title', \Wh::constant_key(_MAIN_OPTIONS_,  "_site_title_"))
@section('metad', \Wh::constant_key(_MAIN_OPTIONS_,  "_metad_"))
@section('metak', \Wh::constant_key(_MAIN_OPTIONS_,  "_metak_"))
@section('content')
 
<div class="infinite-scroll">
          @foreach ($rows as $product)  
             @include('theme::layouts.product')
          @endforeach
      <div class="clear"></div> 
     <div class="col-md-12">
        {!! $rows->appends(Input::all())->render() !!}
    </div>
 </div>    
 
@stop