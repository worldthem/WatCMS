@extends('theme::default')

@section('title', \Wh::constant_key(_MAIN_OPTIONS_,  "_site_title_"))
@section('metad', \Wh::constant_key(_MAIN_OPTIONS_,  "_metad_"))
@section('metak', \Wh::constant_key(_MAIN_OPTIONS_,  "_metak_"))

@section('content')
 
 
<div class="col-sm-12">
     <div class="features_items"><!--features_items-->
       <h2 class="title text-center">{{ _l('All products')}}</h2>
    </div>
</div><!--features_items-->
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