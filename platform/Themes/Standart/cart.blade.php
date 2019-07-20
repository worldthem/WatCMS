@extends('theme::default')
@section('title', _l('Cart'))

@section('content')
    @if ( $cartnr > 0 )
      
      <div class="update_ajax_cal col-md-12">  
       @include('standart.cart.cartittem')
     </div>  
    
    @else
        
          <div class="content-404 text-center"> 
             <h1>
               {{  _l("Look like your cart it's empty") }}
            </h1>
         </div>
     @endif
     

@stop