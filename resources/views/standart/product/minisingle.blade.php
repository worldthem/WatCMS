<?php 
    $list= \Wh::get_images($product->id );
    $options = @json_decode($product->attr);
    $attributes = @\Wh::get_variation("_attributes_");
   if(!empty($list)){
    $list[]= \Wh::json_key(@$product->optionsdata,  "image");
   } 
   $getSidebar = \Wh::get_settings('product-single','value1');
 ?> 
  {!! \Wh::quickEdit('/admin/product/'.@$product->id) !!}
     <div class="miniSingle">   
           <div class="col-sm-{{!empty($getSidebar)? '5':'7'}} singleLeftSide">
               <div class="view-product{{empty($list)? 'fullwidth':''}}">
                   <div class="position_imageload"></div>
                   <a data-fancybox="gallery" class="main_image_link"  href="{{ @\Wh::get_thumbnail(@$product->optionsdata, "big") }}" onclick="return zoom_image(this);">
                     <img class="big_img_product" src="{{ @\Wh::get_thumbnail(@$product->optionsdata, "big") }}" alt="" />
                  </a> 
               </div>
                
                <!-- Wrapper for slides -->
                @if(!empty($list))
                 <div class="single_product_images">
                   @foreach($list as $img) 
                    <a data-fancybox="gallery" class="gallery_product" href="{{ @\Wh::get_thumbnail(@$img, "big") }}"  onclick="return replace_image_with(this);">
                      <img src="{{ @\Wh::get_thumbnail(@$img) }}" alt="">
                    </a>
                   @endforeach 
                 </div>
                @endif 
                  <div class="clear"></div>   
             </div>
             <div class="col-sm-5 singleRightSide" >
                    <div class="product-information">
                             
                         <!--/product-information-->
                             <h2>{{ $product->title }} </h2>
                             <span id="price_each" class="priceSinglePage"> {!! \Wh::get_price_full($product->price,$product->sale_price) !!}</span>
                              
                             
                             
                            <div class="clear"></div>
                            <?php $id_random = \Wh::get_random(10, "yes")?>
                            <form action="#" id="{{$id_random}}" onsubmit="wajax('.result{{$id_random}}', 'reset', '#{{$id_random}}' ); return false;">
                                <input type="hidden" name="action" value="AddToCart" />
                                <input type="hidden" name="id" value="{{$product->id}}" />
                                <input type="hidden" name="max_qtu" id="max_qtu" value="{{$product->qtu}}" />
                                
                                @if(isset($options->variation) && count($options->variation)>0  )
                                  <p>
                                    <select name="options" class="select_options_product" required="" onchange="update_price(this);">
                                       
                                        @foreach($options->variation  as $k_v=> $val)
                                          <option value="{{ $k_v }}" {!! $val->qtu>0? '':'disabled' !!} qtu='{{ $val->qtu }}' price="{!! $val->price >0 ? \Wh::get_price_full($val->price): '0'!!}">
                                               {{ @\Wh::ret_option(@$val, @$attributes) }}
                                          </option>  
                                        @endforeach
                                    </select>
                                  </p>
                                @endif
                                    <div class="clear"></div>
                                     <div class="quantityAdd font_single">
                                         <span class="incrementSingle" onclick="IncrementDecrement('-');"></span>
                                          <input type="text" value="1" class="qtu_entered" name="qtu" required=""   />
                                         <span class="incrementSingle" onclick="IncrementDecrement();"></span>
                                     </div>
                                     <button type="submit"  class="btn btn-fefault cart" style="width: 100%;">
                                       <i class="fa fa-shopping-cart"></i>
                                       {{_l('Add to cart')}}
                                     </button>
                                 
                           </form>
                            <div class="show_erroraddcart result{{$id_random}}"></div>
                          <hr/>
                             <p>
                                  {!! $product->description !!}
                             </p>
                          
                    </div><!--/product-information-->
            </div>
           {!! !empty($getSidebar)? '<div class="col-md-2">'.$getSidebar.'</div>':'' !!}
    </div>        
   <div class="clear_20px"></div>         
   
<?php 
  $tabs = \Wh::productTab($product);
  ?>
  
    @if(!empty($tabs)) 
         <div class="category-tab shop-details-tab"><!--category-tab-->  				
            <div class="col-sm-12">
    	       <ul>{!! @$tabs['tabsName'] !!}</ul>  
    	    </div>
    	
             <div class="tab-content">
              	{!! @$tabs['tabsContent'] !!}
            </div>
            <div class="clear_10px"></div>
        </div><!--/category-tab-->
         <div class="clear_30px"></div>
    @endif  
    
        <div class="col-md-12">
            <h2>{{_l('Related Products')}}</h2>
            <div class="mainRelated">
             {!! \Wh::relatedProducts($product->id, $product->cat) !!}
             <div class="clear"></div>
          </div> 
        </div>     