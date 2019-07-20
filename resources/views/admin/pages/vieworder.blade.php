@extends('admin.layouts.default')

@section('title', 'Order NR.'.$vorder->id)
@section('content')
  
 <div class="col-md-12">
    <div class="card">
     
     
        <div class="header">
            <h4 class="title">{{ _l('Order number') }}: {{ $vorder->id }}</h4>
        </div>
        <div class="content table-responsive table-full-width">
 
  
<div class="col-md-12">
<table class="table">
      
    <tr class="rem1">
       <th>{{ _l('Order Status') }}:</th>
       <td>
          <select class="form-control"  onchange="if (this.value) window.location.href=this.value">
            <?php 
              $status = _STATUS_LIST;
              ?>
              @if(is_array($status))
                @foreach($status as $k=>$v) 
                   <option value="{{URL::to('/')}}/admin/orders/change-status/{{@$vorder->id}}/{{$k}}" {{@$vorder->status == $k ? ' selected=""':''}}>{{@$vorder->status == $k ? $k : $v }}</option>
                @endforeach
              @endif 
          </select>
       </td> 
   </tr>
   <tr class="rem5">
       <th>Status from payment system:</th>
       <td>{{ $options->payment_status ?? '' }} </td> 
   </tr>
    
    <tr class="rem2">
       <th>{{_l("Date")}}:</th>
       <td>{{ date("d/m/Y", strtotime($vorder->created_at)) }}</td> 
   </tr>
      <?php $total = 0;
            $cart = @\Wh::get_cart(4,$vorder->id);
      ?>
      @foreach($cart as $v)
       <?php $total = $total + $v->cart_price;
           $optionsCart = @json_decode($v->attr);
       ?>
          <tr>
             <th>
                <a href="{{ url("/admin/product/".$v->pid)}}">
                 {{$v->title}}
                </a><b> x {{$v->qty}}</b> 
                @if(!empty($v->options_id)) 
                <div class="optionss">
                    <i>{{ @\Wh::ret_option(@$optionsCart->variation[$v->options_id] ?? '') }}</i>
               </div>
                @endif
              </th>
               <td class="invert">{{ $v->cart_price ?? '' }} {{ $optionsCart->currency ?? '' }}</td>
           </tr>
             
              
                  @foreach(\Wh::get_admin_files($v->pid, "array") as $upload) 
                   <tr>
                      <th style="padding-left: 15px;">{{$upload->file_title ?? '' }} </th>
                      <td> 
                         <a href="{{ url("/upload-file")."/".$upload->id."/".$vorder->id }}">
                           <b><i class="fa fa-download"></i>{{_l("Download")}}  </b> 
                         </a>
                          {{ !empty($optionsCart->downloaded) ? "(Downloaded ".$optionsCart->downloaded." time)":"" }}
                       </td>
                   </tr>
                   @endforeach
              
      @endforeach
         
          <tr class="rem3">
               <th> {{_l("Subtotal")}}: </th>
               <td><b>{{$total}} {{ $options->currency ?? '' }}</b></td> 
          </tr>
       
       {!! \Wh::hooks('singleorderAdmin', ['order'=>$vorder]) !!} 
         
        @if(!empty($shipping->cupon_name))
            <tr class="cart-subtotal">
    			<th>{{_l("Cupon")}}</th>
    			<td>{{ $shipping->cupon_name ?? '' }}</td>
    		</tr>
            <tr class="cart-subtotal">
    			<th>{{_l("Discount")}}</th>
    			<td>- {{ $shipping->cupon_discount ?? '0'}} {{ $options->currency ?? '' }}</td>
    		</tr>
          @endif
       
      @if(!empty($shipping->shipping_id))  
         <tr class="rem4">
           <th>
             {{_l("Shipping")}} 
             ( <i>{{ \Wh::get_shipping_field($shipping->shipping_id,  'shipping_name') }}</i> )
           </th>
           <td>{{ $shipping->delivery_price }} {{ $options->currency }}</td> 
         </tr>
      @endif
      
    <tr class="rem4">
       <th>{{_l("Payment Method")}} :</th>
       <td>
             {{ !empty($payment_systems[($options->payment_type ?? '')]['name'])? 
                     $payment_systems[($options->payment_type ?? '')]['name'] : ($options->payment_type ?? '')  }}
       </td> 
   </tr>
   <tr class="rem5">
       <th>{{_l("Total")}} ({{_l("no shipping include")}}):</th>
       <td>{{$options->price_total ?? 0}} {{ $options->currency ?? '' }}</td> 
   </tr>
   
    
     <tr class="rem3">
       <th>{{_l("Total payd")}}:</th>
       <td>{{$options->payd ?? 0}} {{ $options->currency ?? '' }}</td> 
    </tr>
    <tr>
        <td><br /></td>
        <td></td>
    </tr>
    
    @if(!empty($vorder->user_id))
     
      <tr class="rem7">
          <th> <b>{{_l("User")}}  :</b> </th>
          <td>
          <a href="{{URL::to('/')}}/admin/users/single/{{$vorder->user_id}}">
             {{@\Wh::get_user_name($vorder->user_id, email)}} 
          </a>
          | <a href="{{URL::to('/')}}/admin/view-user-orders/{{$vorder->user_id}}">{{_l("View all orders")}} </a>
         </td>
     </tr>
    @endif
    <tr>
        <td><br /></td>
        <td></td>
    </tr>
 </table>
 
</div>

 <div class="clear_40px"></div>
 
 
@if(!empty($order_billing))  
 <div class="col-md-6">
   <h2><i>{{$fields['header']['name']}}</i></h2>
    <table class="table"> 
      @foreach($order_billing as $k5=>$v5)
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

 @if(!empty($order_shipping)) 
 <div class="col-md-6">
   <h2><i>{{$fields_shipping['header']['name']}}</i></h2>
    <table class="table"> 
       @foreach($order_billing as $k5=>$v5)
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
 
            <div class="clear"></div>    
            
         </div>
       </div>
    </div>
 
 @stop