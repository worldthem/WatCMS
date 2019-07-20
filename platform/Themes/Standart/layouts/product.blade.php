<?php 
 
$open_modal= 'onclick="modaljs(this,\'show\',\'ajax\'); return false;" data-modal="#mini-modal" data-ajax="action=mini_single&id='.$product->id.'"';
$add_cart = \Wh::check_opt($product->attr) ? $open_modal : 
                                'onclick="wajax(\'.add_class'.$product->id.'\', \'action=AddToCart&id='.$product->id.'&qtu=1&max_qtu='.$product->qtu.'\' ); return false;"';
$image = json_decode($product->optionsdata,true); 
?>
 
<div class="col-product-list">
    <div class="product-image-wrapper">
        <div class="single-products">
            <div class="productinfo text-center">
                    <a class="image_product" href="{{ \Wh::product_url($product->cpu, $product->cat) }}">
                      <img class="lazy_load" src="{{ @\Wh::get_thumbnail($product->optionsdata,'json') }}" data-src="{{ @\Wh::get_thumbnail($product->optionsdata,'json') }}" alt="{{ $product->title }}" /> 
                    </a>
             </div>
        </div> 
           <div class="product-text">   
                    <p><a href="{{ \Wh::product_url($product->cpu, $product->cat) }}"> {{ $product->title }} </a></p>
                   
                      <div class="product_stars"> 
                       {!! \Wh::product_stars($product->id) !!}
                     </div>
            </div>
         <div class="choose info-bottom">
            <div>
              {!! \Wh::get_price_full($product->price,$product->sale_price) !!} 
           </div>
            <a href="#" class="btn btn-default add-to-cart" {!! $add_cart !!} >
                <i class="fa fa-shopping-cart"></i>
                <span class="add_class{{$product->id}}"> </span>
            </a>
        </div>
    </div>
</div>