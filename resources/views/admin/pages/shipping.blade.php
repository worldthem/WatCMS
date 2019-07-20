@extends('admin.layouts.default')

@section('title', 'Shipping')
@section('content')
 
<div class="col-md-12">
 <div class="card">
       
   
     <div class="header">
           <h4 class="title"> {{ _l('Shipping method') }}</h4>
     </div>
     
     <div class="clear"></div>
     
     <div class="add_new_top">  
    <form action="{{URL::to('/')}}/admin/setting/shipping/store" method="post">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input type="hidden" name="id" value="new">
         
           <div class="col-md-2">
             <label>  {{ _l('Title') }} <br />
                <input type="text" name="shipping_name" class="form-control"/>
             </label>
          </div>
          
          
         <div class="col-md-2">
          <label> Select country <br />
             <select class="form-control" name="country">
                <option value=""> {{ _l('For all countries (Worldwide)') }}</option>
                 @foreach(@$countries as $country)
                   <option value="{{@$country->id}}">{{@$country->country}} </option>
                 @endforeach  
               </select>
                
          </div>
          
          <div class="col-md-2">
             <label>  {{ _l('Weight') }} kg<br />
                <input type="text" name="weight" class="form-control"/>
                <small> {{ _l("Leave empty if you don't use Weight") }}</small>
             </label>
          </div>
           <div class="col-md-2">
             <label>  {{ _l('Shipping calculation') }} <br />
                  <select name="type_shipping" class="form-control" >
                   <option  value="2"> {{ _l('Fixed') }}</option>
                   <option value="3" > {{ _l('Percentage from Total') }}</option>
                 </select>
             </label>
          </div>
           <div class="col-md-2">
             <label>  {{ _l('Fixed Or') }} %<br />
                <input type="text" name="price" class="form-control" placeholder="25"/>
             </label>
             <small> {{ _l('Fixed Price 25$ OR  Percentage 25% from basket total') }}</small>
          </div>
          <div class="col-md-2" style="background: #A2A2A2;">
            <label>  {{ _l('Free') }} <br />
                <input type="text" name="free_delivery" class="form-control" placeholder="1000" />
            </label>
             <small> {{ _l("Free when basket total is bigger than this ammount, leave empty if don't need") }}</small>
          </div>
          
        <div class="col-md-12 text_align_right"><br />
           <button type="submit" class="btn btn_small"> {{ _l('Add new one') }}</button>  
        </div>
         
     <div class="clear"></div>
    </form> 
   </div>   
     
     <form action="{{URL::to('/')}}/admin/setting/shipping/destroy-bulk" method="post">
         <input type="hidden" name="_token" value="{{ csrf_token() }}">
           <div class="col-md-2">
             <select name="action" class="form-control" >
                <option value=""> {{ _l('Action') }}</option>
                <option value="del"> {{ _l('Remove') }} </option>
                <option value="3"> {{ _l('Hide') }}  </option>
                <option value="2"> {{ _l('Show') }}  </option>
            </select>
          </div>
         
        <div class="col-md-1">
           <button type="submit" class="btn btn_small"> {{ _l('Apply') }}</button>  
        </div>
        <div class="col-md-6"><br /></div>
     <div class="col-md-3" class="text_align_right">
    
      @if(@$countries)  
        <select class="form-control"  onchange="if (this.value) window.location.href=this.value">
            <option value=""> {{ _l('Select country') }}</option>
            @foreach(@$countries as $country)
               <option value="{{URL::to('/')}}/admin/setting/shipping/show-method/{{@$country->id}}" {{@$country->id==$selected_country? ' selected=""':''}} >{{@$country->country}} </option>
             @endforeach  
       </select>
      @endif
     </div>
         <div class="clear"></div>
        
     <div class="content table-responsive table-full-width">
         <table class="table table-hover table-striped">
             <thead>
                 <th style="width: 30px;"><input type="checkbox" id="checkall" onclick="check_all(this);" /></th>
                 <th style="width: 30px;">ID</th>
                 <th style="width: 50px;"> {{ _l('Show/Hidden') }}</th>
                 <th> {{ _l('Title') }}</th>
                 <th> {{ _l('Country') }}</th>
                 <th> {{ _l('Weight(kg)') }}</th>
                  <th> {{ _l('Shipping Calculation') }}</th>
                 <th> {{ _l('Fixed Price OR  Percentage(%)') }}</th>
                 <th> {{ _l('Free delivery') }}</th>
                 <th style="width: 40px;"></th>
                 <th style="width: 40px;"></th>
             </thead>
             <tbody>
                @foreach ($shipping as $val)

                 <tr>
                    <td> <input type="checkbox" name="productid[]" class="checkboxeach"  value="{{$val->id}}"></td>
                     <td>{{$val->id}}</td>
                     <td>
                      {!! $val->hide_show == "2"? '<span class="fa_publish"></span>':'<span class="fa_unpublish"></span>'!!}
                     </td>
                      
                     <td>
                        <input type="text" class="data_1_get{{$val->id}}" data-value="{{$val->shipping_name}}" value="{{$val->shipping_name}}" onfocusout="save_field('{{URL::to('/')}}/admin/setting/shipping/store', '.result{{$val->id}}', '{{$val->id}}', 'shipping_name' , '.data_1_get{{$val->id}}');" />
                     </td>
                     <td>{{$val->country>0 ?  @\Wh::get_countrybyid($val->country, 'country'):_l('Worldwide')  }}</td>
                     <td>
                       <input type="text" class="data_2_get{{$val->id}}" data-value="{{$val->weight}}" value="{{$val->weight}}" onfocusout="save_field('{{URL::to('/')}}/admin/setting/shipping/store', '.result{{$val->id}}', '{{$val->id}}', 'weight' , '.data_2_get{{$val->id}}');" />
                     </td>
                      <td> 
                         <select class="data_4_get{{$val->id}}" onchange="save_field('{{URL::to('/')}}/admin/setting/shipping/store', '.result{{$val->id}}', '{{$val->id}}', 'type_shipping' , '.data_4_get{{$val->id}}');">
                           <option  value="2"> {{ _l('Fixed') }}</option>
                           <option value="3" {{$val->type_shipping =="3" ? 'selected=""': ''}}> {{ _l('Percentage from Total') }}</option>
                         </select>
                     </td>
                     <td> 
                         <input type="text" class="data_3_get{{$val->id}}" data-value="{{$val->price}}" value="{{$val->price}}" onfocusout="save_field('{{URL::to('/')}}/admin/setting/shipping/store', '.result{{$val->id}}', '{{$val->id}}', 'price' , '.data_3_get{{$val->id}}');" />
                    </td>
                       <td> 
                         <input type="text" class="data_7_get{{$val->id}}" data-value="{{$val->free_delivery}}" value="{{$val->free_delivery}}" onfocusout="save_field('{{URL::to('/')}}/admin/setting/shipping/store', '.result{{$val->id}}', '{{$val->id}}', 'free_delivery' , '.data_7_get{{$val->id}}');" />
                       </td>
                      <td> 
                         <a href="{{URL::to('/')}}/admin/setting/shipping/destroy/{{$val->id}}" class="fa_delete" onclick="return confirm('You are sure?') ? true : false;"></a>
                     </td>
                     <td class="result{{$val->id}}"></td>
                 </tr>
                @endforeach
             </tbody>
         </table>
      </form>    
{!! $shipping->appends(Input::all())->render() !!}
     </div>
 </div>
</div>
@stop