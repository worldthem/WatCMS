<?php $total_cart = \Wh::get_cart();
       $total = 0;
       
 ?>
 @if(!empty($total_cart))
 <div class="col-md-8">
   
 <table class="cartTable">
     @foreach($total_cart as $v)
       <?php  
          $options = @json_decode($v->attr);
          $_cart = \Wh::cart_operation(@$v,@$options );
          $total = $total + @$_cart['total'];
        ?>
       @if($_cart['quantity'] > 0)
        <tr>
                 
                <td class="imageCart">
                    <a href="{{\Wh::product_url($v->cpu,$v->cat)}}" >
                        <img src="{{ @\Wh::get_thumbnail(@$v->optionsdata) }}" alt=" " class="img-responsive"   />
                    </a>
                </td>

                <td class="cartData">
                    <div class="deleteIttemCart">
                      <a href="#" class="closeCart" onclick="wajax('#result_cart{{$v->cartid}}', 'action=actioncart&type=del&id={{$v->cartid}}'); return false;"><i class="fa fa-close" aria-hidden="true"></i></a>
                    </div>
                  
                  <div class="cartTitle">
                     <a href="{{\Wh::product_url($v->cpu,$v->cat)}}" >
                        {{$v->title}}
                    </a>
                    @if(is_numeric($v->options_id)) 
                    <div class="optionss">
                        <i>{{ @\Wh::ret_option(@$options->variation[$v->options_id]) }}</i>
                   </div>
                    @endif
                  </div>  
                  <div class="cartPrice">
                          <div class="quantityAdd cartQuantity">
                             <span class="incrementSingle"  onclick="wajax('#result_cart{{$v->cartid}}', 'action=actioncart&type=incr&id={{$v->cartid}}&qty={{@$_cart['quantity_cart'] - 1}}&opt={{@$_cart['quantity']}}'); return false;"> </span>
                              <input type="text"   class="qtu_entered qtu_cart{{$v->cartid}}" value="{{$v->qty}}"  onchange="wajax('#result_cart{{$v->cartid}}', 'action=actioncart&type=incr&id={{$v->cartid}}&qty='+this.value+'&opt={{@$_cart['quantity']}}');"   />
                             <span class="incrementSingle" onclick="wajax('#result_cart{{$v->cartid}}', 'action=actioncart&type=incr&id={{$v->cartid}}&qty={{@$_cart['quantity_cart'] + 1}}&opt={{@$_cart['quantity']}}'); return false;"> </span>
                          </div>
                        
                         <div class="priceTotalCart">{!! \Wh::get_price_full(@$_cart['total']) !!}</div>
                           
                       <div class="clear"></div>
                       @if($iderr == $v->cartid)  
                          {!! $err !!}
                       @endif
                       <div id="result_cart{{$v->cartid}}"></div>  
                  </div>  
                   
                </td>
                 
                 
        </tr>
        @endif
        @endforeach
         
    </table>
 <div class="clear"></div>

  
 </div>
 <div class="col-md-4">
  <div class="cartTotalsRight">
  <?php $cuppon = @\Wh::get_applied_cupon($total,'yes');?>
   
  <div class="cuppon_code">
       <form method="post" id="submit_cupon" onsubmit="wajax('.result_cuppon', 'reset', '#submit_cupon' ); return false;">
          <input type="hidden" name="action" value="CuponApply" />
          <input type="text" name="cuppon" placeholder="{{ _l('Coupon Code') }}" value=""/>
          <input type="submit" name="submit" class="submitCuppon" value="{{ _l('Apply coupon') }}" />
       </form>
       <div class="clear result_cuppon"></div>
   </div> 
 
  <div class="cartSubtotalTable">
        <table class="cart_subtotal">
        @if(is_array($cuppon))
                <tr class="cart-subtotal">
        			<th>Subtotal</th>
        			<td>{!! @\Wh::get_price_full(@$cuppon['subtotal'],0,'none') !!}</td>
        		</tr>
                <tr class="cart-subtotal">
        			<th>{{ _l('Cupon') }}</th>
        			<td>{{@$cuppon['cuppon']}}</td>
        		</tr>
                <tr class="cart-subtotal">
        			<th>{{ _l('Discount') }}</th>
        			<td>- {!! @\Wh::get_price_full(@$cuppon['discount'],0,'none') !!}</td>
        		</tr>
                <tr class="cart-subtotal">
        			<th>{{ _l('Total') }}:</th>
        			<td> {!! @\Wh::get_price_full(@$cuppon['total'],0,'none') !!}</td>
        		</tr>
                @else
                <tr class="cart-subtotal">
        			<th>{{ _l('Sub Total') }}:</th>
        			<td> {!! @\Wh::calcTotal(@$total, "full") !!}</td>
        		</tr>
                <tr class="cart-subtotal">
        			<th>{{ _l('Total') }}:</th>
        			<td> {!! @\Wh::calcTotal(@$total, "full") !!}</td>
        		</tr>
                @endif 
        </table>
    </div>
       <div class="clear_20px"></div>
     <a class="large_button goToCheckout" href="{{URL::to('/')}}/steps/checkout/">{{ _l('Checkout') }}</a>
   
   
   </div>
  </div>  
 <div class="clear_40px"></div>  
@else
 <h2>{{_l("Empty")}}</h2>
@endif 