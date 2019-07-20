<div class="col-md-12">
@if(count($order) > 1)
  <table class="table" >
    <tr>
        <th>{{ _l('Order Nr.')}}</th>
        <th>{{ _l('Date')}}</th>
        <th>{{ _l('Status')}}</th>
        <th>{{ _l('Total')}}</th>
        <th></th>
    </tr>
  
    @foreach($order as $vorder) 
         <tr class="rem1">
           <td>
              <a href="/steps/viewOrder/{{$vorder->id}}/{{$vorder->secretnr}}" class="btn">
                {{$vorder->id}}
              </a>
           </td>
           <td>{{ date("d/m/Y", strtotime($vorder->created_at)) }}</td>
           <td>{{ucfirst($vorder->status) }}</td>
          <td>{{ \Wh::json_key($vorder->options, 'payd') }} {{ \Wh::json_key($vorder->options, 'currency') }} </td> 
          <td> 
           <a href="/steps/viewOrder/{{$vorder->id}}/{{$vorder->secretnr}}" class="btn">{{ _l('View Order') }}</a>
          </td>
         </tr>
    @endforeach   
  </table>
  
    
@else

@forelse($order as $vorder)
  <?php 
     $options = @json_decode($vorder->options);
     $shipping = @json_decode($vorder->shipping);
  ?>
  <h3 class="text-center">NR:{{ $vorder->id }}</h3>
  <div class="clear_10px"></div>


<div class="checkout-right">
<table class="table">
     <tr class="rem1">
       <td>{{ _l('Order Nr.') }} </td>
       <td>{{ $vorder->id }}</td> 
     </tr>
    <tr class="rem1">
       <td>{{ _l('Status') }}:</td>
       <td>{{ _l(ucfirst($vorder->status)) }}</td> 
   </tr>
    
    <tr class="rem2">
       <td>{{ _l('Date') }}:</td>
       <td>{{ date("d/m/Y", strtotime($vorder->created_at)) }}</td> 
   </tr>
      <?php $total =0;
            $cart = @\Wh::get_cart(4,$vorder->id);
      ?>
      @foreach($cart as $v)
      <?php $total = $total + $v->cart_price;
            $optionsAttr = @json_decode($v->attr);
         ?>
          <tr>
             <th>
                <a href="{{ \Wh::product_url($v->cpu,$v->cat) }}">
                 {{$v->title}}
                </a><b> x {{$v->qty}}</b> 
                @if(!empty($v->options_id)) 
                <div class="optionss">
                    <i>{{ @\Wh::ret_option(@$optionsAttr->variation[$v->options_id]) }}</i>
                </div>
                @endif
              </th>
               <td class="invert">{{ $v->cart_price }} {{ $vorder->currency }}</td>
           </tr>
             
             @if($vorder->status=="completed" || $vorder->status=="processing")  
                  @foreach(\Wh::get_admin_files($v->pid, "array") as $upload) 
                   <tr>
                      <th style="padding-left: 15px;">{{$upload->file_title}} </th>
                      <td> 
                         <a href="{{ url("/upload-file")."/".$upload->id."/".$vorder->id }}">
                           <b><i class="fa fa-download"></i> {{ _l('Download') }} </b> 
                         </a>
                       </td>
                   </tr>
                   @endforeach
              @endif
           
            <tr>
                <td><br /></td>
                <td></td>
           </tr>
     @endforeach
     
     {!! \Wh::hooks('singleorder', ['order'=>$vorder]) !!}
     
    @if($total > 0) 
      <tr class="rem3">
       <th> {{ _l('Subtotal') }} : </th>
       <td><b>{{$total}} {{ $options->currency ?? '' }}</b></td> 
      </tr>
     @endif
      
     @if(!empty($shipping->cupon_name))
        <tr class="cart-subtotal">
			<th>{{ _l('Cupon') }}:</th>
			<td>{{ $shipping->cupon_name ?? ''}}</td>
		</tr>
        <tr class="cart-subtotal">
			<th>{{ _l('Discount') }}</th>
			<td>- {{ $shipping->cupon_discount ?? 0}} {{ $options->currency ?? '' }}</td>
		</tr>
      @endif
     
     
      @if(!empty($shipping->shipping_id))  
         <tr class="rem4">
           <td>
              {{ _l('Shipping') }}:<br />
             <i>{{ \Wh::get_shipping_field(($shipping->shipping_id ?? ''),  'shipping_name') }}</i>
           </td>
           <td>{{ $shipping->delivery_price ?? 0}} {{ $options->currency ?? '' }}</td> 
         </tr>
      @endif
      
     <tr class="rem3">
       <th>{{ _l('Total') }}: </th>
       <td><b>{{$options->payd ?? 0}} {{ $options->currency ?? '' }}</b></td> 
      </tr>
 </table>
 
</div>

 <div class="clear_40px"></div>
 
 @if (Auth::check()) 
 
<?php 
   $fields= @\Wh::get_settings_json('billing_fields');
   $fields_shipping= @\Wh::get_settings_json('shipping_fields');
?>
@if(!empty($shipping->billing))  
 <div class="col-md-6">
   <h2><i>{{$fields['header']['name']}}</i></h2>
    <table class="table"> 
      @foreach($shipping->billing as $k5=>$v5)
            @if(!empty($v5))
                <tr>
                  <th> {{$fields[$k5]['name']}}:</b></th>
                 <td>
                  {{ $k5=="country" ? \Wh::get_countrybyid($v5, "country") : $v5 }}   
                </td> 
               </tr>
           @endif
      @endforeach
  </table>   
 </div>
@endif 

@if(!empty($shipping->shipping)) 
 <div class="col-md-6">
   <h2><i>{{$fields_shipping['header']['name']}}</i></h2>
    <table class="table"> 
       @foreach($shipping->shipping as $k5=>$v5)
         @if(!empty($v5))
            <tr class="rem{{$i}}">
             <th>{{$fields[$k5]['name']}}: </th>
             <td>
                {{ $k5=="country" ? \Wh::get_countrybyid($v5, "country") : $v5 }}   
             </td> 
           </tr>
         @endif  
       @endforeach
    </table>   
 </div>
@endif
 
@endif   
 
      
@empty     

     <div class="content-404 text-center"> 
      <h1> {{ _l('No orders')}} :(   </h1>
     </div> 
     
      
     <div class="clear_40px"></div>

@endforelse

@endif 
</div>
<div class="clear_30px"></div>
