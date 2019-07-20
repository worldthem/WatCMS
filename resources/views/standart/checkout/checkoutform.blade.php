  <div class="checkoutPage">
    <form action='{{url("/wajax.jsp")}}' method="POST" id="checkoutform" onsubmit="return checkout_finall('.resul_checkout', '', '#checkoutform' );" >
        
         <input type="hidden" name="action" value="place_order" />
           
            <div class="col-sm-6">
                     <div class="shopper-info">
                         @include("standart.checkout.fields", ['fields'=> @\Wh::get_settings_json('billing_fields'), "last_address"=>@$last_bill,'kg'=>$kg,'total'=>$cart_total, "key_ship"=>""] )
                         @include("standart.checkout.fields", ['fields'=> @\Wh::get_settings_json('shipping_fields'),"last_address"=>@$last_shipp,'kg'=>$kg, 'total'=>$cart_total, "key_ship"=>"sipping_"] )
                        <div class="clear_20px"></div>
                     </div>
            </div>

                <div class="col-sm-6 paymentDetailsCheckout">
                  <div class="order-message">
                  
                  @if($if_shipping)
                    <div class="register-reqs">{{ _l('Shipping Method') }} </div>
                    <div class="total_area" id="shipping_method" style="width: 99%">
                           <ul style="margin: 0;padding: 0;" class="deliverylist">
                              {!! $default_shiping !!}
                          </ul>
                        <br/>
                    </div>
                   @endif
                   
                   
                    <div class="register-reqs">{{ _l('Payment Method') }} </div>
                    <div class="clear"></div>
                            
                              
                   
                     <div class="total_area" style="width: 99%">
                           <ul style="margin: 0;padding: 0;">
                            @if($if_shipping) 
                             <li style="margin-top: 0;"><b>{{ _l('Merchandise Subtotal') }}</b> <span class="subtotal_price">{!!  @$total_checkout; !!}</span></li>
                             <li><b>{{ _l('Shipping') }}</b> <span class="delivery_cost">{!!\Wh::currency()!!}</span></li>
                            @endif
                             
                             <li><b>{{ _l('Payment Due') }}</b> <span class="total_price">{!!  @$total_checkout  !!}</span></li>
                           </ul>
                     </div>
                           
                            <div class="clear_20px">
                              <hr />
                           </div>  
                          
                         @include('standart.checkout.payments')
                           
                          @if(!empty($term_condition))
                              <label>
                                   <input type="checkbox" name="agred" required="" value="yes"> 
                                   {{ _l('I read and agree to') }}
                                   {!! \Wh::get_link_page($term_condition) !!}
                              </label>
                         @endif    
                        <div class="clear_10px"></div>
                        <div class="resul_checkout text-center"></div>
                        <button type="submit" class="btnplace_order" >
                          {{ _l('Place Order & Pay') }}
                        </button>
                        <div class="clear_10px"></div>
                        {!! \Wh::hooks('afterCheckoutButton') !!} 
                  </div>	
                </div>
                <div class="clear"></div>
          </form>    
    

{!! \Wh::hooks('endCheckoutPage') !!}  
<div class="clear"></div>
</div> 

        