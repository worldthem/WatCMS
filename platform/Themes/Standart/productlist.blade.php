@extends('theme::default')

@section('title', $catname)
@section('content')
 
         <div class="col-md-12">
            {!! \Wh::breadcrumbs() !!}
            @include("theme::layouts.shopHeader")
         </div>
         
          
 
      <div class="infinite-scroll">
         @foreach ($products as $product)  
           @include('theme::layouts.product')
         @endforeach

          <div class="clear"></div> 
          <div class="col-md-12">
            {!! $products->links() !!}
         </div>
      </div>   
    
@stop