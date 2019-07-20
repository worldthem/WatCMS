@extends('admin.layouts.default')

@section('title', 'View orders')
@section('content')
 <?php $status = _STATUS_LIST;  ?>
   <div class="col-md-12">
   <div class="card">
     
   
   
    <div class="header">
        <h4 class="title">Orders</h4>
        <p class="category">{{ _l('Check the list of orders') }}</p>
    </div>
                            
     <form action="{{URL::to('/')}}/admin/orders/bulk" method="post">
         <input type="hidden" name="_token" value="{{ csrf_token() }}">
           <div class="col-md-2">
             <select name="action" class="form-control" >
                <option value="">{{ _l('Action') }}</option>
                <option value="del"> {{ _l('Remove') }} </option>
               
                @if(is_array($status)) 
                    @foreach($status as $k=>$v) 
                    <option value="{{$k}}"> {{$v}} </option>
                    @endforeach
                @endif   
            </select>
          </div>
         
        <div class="col-md-1">
           <button type="submit" class="btn btn_small">{{ _l('Apply') }}</button>  
        </div>
          <div class="col-md-1">
           <br />
        </div>  
     <div class="col-md-3" class="text_align_right">
      
       <select class="form-control"  onchange="if (this.value) window.location.href=this.value">
            <option value="{{URL::to('/')}}/admin/orders/status/all"> {{ _l('All') }}</option>
              
              @if(is_array($status))
                @foreach($status as $k=>$v) 
                   <option value="{{URL::to('/')}}/admin/orders/status/{{$k}}" {{@$getvar == $k ? ' selected=""':''}}> {{$k}} </option>
                @endforeach
              @endif  
        </select>
     </div>
     <div class="col-md-1">
           <br />
        </div>
          <div class="col-md-2">
           <input type="text" class="form-control" name="s" value=""  placeholder="{{ _l('Search') }}"/>
         </div>
          <div class="col-md-2">
            <button type="submit" class="btn btn_small">{{ _l('Search') }}</button>  
          </div>
         
     <div class="clear"></div>
     
                            <div class="content table-responsive table-full-width">
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <th><input type="checkbox" id="checkall" onclick="check_all(this);" /></th>
                                        <th>{{ _l('NR') }}.</th>
                                        <th>{{ _l('Status') }}</th>
                                    	<th>{{ _l('Date') }}</th>
                                    	<th>{{ _l('Payd in') }}</th>
                                    	<th>{{ _l('Country') }}</th>
                                        <th>{{ _l('Shipping') }}</th>
                                        <th>{{ _l('View') }}</th>
                                    </thead>
                                    <tbody>
                                       @foreach ($orders as $order)
                                       <?php 
                                          $shipping = @json_decode($order->shipping);
                                          $addresB = @json_decode($shipping->billing);
                                          $addresS = @json_decode($shipping->shipping);
                                       ?>
                                        <tr> 
                                            <td> <input type="checkbox" name="productid[]" class="checkboxeach"  value="{{$order->id}}"></td> 
                                            <td>{{$order->id}}</td>
                                            <td>{{$order->status}} </td>
                                            <td>{{date("d/m/Y", strtotime($order->created_at))}}</td>
                                            <td>{{ \Wh::json_key($order->options, 'payd') }} {{ \Wh::json_key($order->options, 'currency') }}</td>
                                            <td>{{ \Wh::get_countrybyid(($addresB ?? ($addresS) ?? ''), 'country')    }}</td>
                                            <td>{{ @\Wh::get_shipping_field(($shipping->shipping_id ?? 0),  'shipping_name') }} : {{ $shipping->delivery_price ?? '' }} </td>
                                            <td> 
                                                <a href="{{URL::to('/')}}/admin/vieworder/{{$order->id}}">View order</a>
                                            </td>
                                        </tr>
                                        <?php $shipping = null; $addresB=null; $addresS =null; $order =null;  ?>
                                       @endforeach
                                    </tbody> 
                                </table>
                                  {!! $orders->appends(Input::all())->render() !!}
                            </div>
                             </form>  
                        </div>
                    </div>
      

@stop 