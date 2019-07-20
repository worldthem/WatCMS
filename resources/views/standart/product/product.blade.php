<?php 
 
$open_modal= 'onclick="modaljs(this,\'show\',\'ajax\'); return false;" data-modal="#mini-modal" data-ajax="action=mini_single&id='.$product->id.'"';
$add_cart = \Wh::check_opt($product->attr) ? $open_modal : 
                                'onclick="wajax(\'.add_class'.$product->id.'\', \'action=AddToCart&id='.$product->id.'&qtu=1&max_qtu='.$product->qtu.'\' ); return false;"';
 
$src = isset($fullIMG) ? @\Wh::get_thumbnail($product->optionsdata,'json') : 
                         'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABAQAAAAA3bvkkAAAAAnRSTlMAAQGU/a4AAAAKSURBVHgBY2gAAACCAIFMF9ffAAAAAElFTkSuQmCC';
?>
  
<div class="col-product-list">
                 <div class="image_product text-center">
                    <a href="{{ \Wh::product_url($product->cpu, $product->cat) }}"> 
                     <img class="lazy_load" src="{!! $src !!}" data-src="{{ @\Wh::get_thumbnail($product->optionsdata,'json') }}" alt="{{ $product->title }}" /> 
                   </a>    
                         <ul class="w3_hs_bottom">
                            <li>
                                <a href="#" class="view-product-mini"  {!! $open_modal !!} >
                                   <i class="fa fa-eye"  ></i> 
                                </a>
                            </li>
                            <li>
                             <a href="#" onclick="wajax('.add_wishlist{{$product->id}}', 'action=AddToWishlist&id={{$product->id}}'); return false;">
                                       <i class="fa fa-heart"></i>
                                       <span class="add_wishlist{{$product->id}}"></span>
                                   </a>
                            </li>
                           
                         </ul>
		           </div>
                                      
                 <div class="productDataList"> 
                  <div class="productInfoLeft"> 
                     <a href="{{ \Wh::product_url($product->cpu, $product->cat) }}"> {{ $product->title }} </a> 
                     <p> 
                      {!! \Wh::get_price_full($product->price,$product->sale_price) !!}
                     </p>
                  </div> 
                    
                    <div class="productInfoRight">
                      <a href="#"  {!! $add_cart !!} >
                        <i class="fa fa-shopping-basket"></i>
                        <span class="add_class{{$product->id}}">  </span>
                      </a>
                       
                    </div>
                    <div class="clear"></div>
                      <div class="product_stars"> 
                         {!! \Wh::product_stars($product->id) !!}
                     </div>
                 </div> 
 </div>