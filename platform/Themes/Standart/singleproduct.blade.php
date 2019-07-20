@extends('theme::default')

@section('title', @$product->title)
@section('content')
 
<div class="col-sm-12">
 
 @include('standart.product.minisingle') 
      
<div class="recommended_items"><!--recommended_items-->
   {!! \Wh::hooks('relatedProducts') !!}
</div><!--/recommended_items-->       
        
</div>
    
    
@stop