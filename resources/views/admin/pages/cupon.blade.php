@extends('admin.layouts.default')

@section('title', 'Cuppon')
@section('content')
 
<div class="col-md-12">
 <div class="card">
       
         <div class="header">
           <h4 class="title">{{ _l('Cuppon') }}</h4>
        </div>
     <div class="add_new_top">  
    <form action="{{URL::to('/')}}/admin/cupon/new" method="post">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input type="hidden" name="id" value="new">
          <div class="col-md-2">
             <label> {{ _l('Discount type') }} <br />
                  <select name="type" class="form-control" >
                     <option value="fix">{{ _l('Fixed cart discount') }}</option>
                     <option value="percent">{{ _l('Percentage cart discount') }}</option>
                 </select>
             </label>
          </div>
           <div class="col-md-2">
             <label> {{ _l('Cupon Name') }} <br />
                <input type="text" name="cupon" required="" class="form-control"/>
             </label>
          </div>
          
          
          
          <div class="col-md-3">
             <label> {{ _l('Coupon amount') }}<br />
                <input type="text" name="amount" required="" class="form-control"/>
             </label>
          </div>
          
            
         <div class="col-md-1"><br />
           <button type="submit" class="btn btn_small">{{ _l('Add new one') }} </button>  
        </div>
         
     <div class="clear"></div>
    </form> 
   </div> 
     
     <form action="{{URL::to('/')}}/admin/cupon/destroy-bulk" method="post">
         <input type="hidden" name="_token" value="{{ csrf_token() }}">
           <div class="col-md-2">
               <select name="action" class="form-control" >
                    <option value="">{{ _l('Action') }}</option>
                    <option value="del">{{ _l('Remove') }}  </option>
               </select>
          </div>
         
        <div class="col-md-1">
           <button type="submit" class="btn btn_small">{{ _l('Apply') }}</button>  
        </div>
           <div class="col-md-5"><br /></div>
          
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
                 <th>{{ _l('ID') }}</th>
                 
                 <th>{{ _l('Name') }}</th>
                 <th>{{ _l('Coupon amount') }}</th>
                 <th>{{ _l('Discount type') }}</th>
                 <th>{{ _l('Usage') }}</th>
                  <th>{{ _l('Date') }}</th>
                 <th style="width: 40px"> </th>
                 <th style="width: 40px"> </th>
             </thead>
             <tbody>
                @foreach ($rows as $val)

                 <tr id="edit_this_nr{{$val->id}}"> 
                       <td> <input type="checkbox" name="productid[]" class="checkboxeach"  value="{{$val->id}}"></td>
                       <td>{{$val->id}}</td>
                       
                       <td>
                           <div class="edit_text">{{$val->cupon}}</div>
                           
                           <input type="text" class="form-control data_1_get{{$val->id}} hide_edit" data-value="{{$val->cupon}}"  onfocusout="save_field('{{URL::to('/')}}/admin/cupon/store', '.result{{$val->id}}', '{{$val->id}}', 'cupon' , '.data_1_get{{$val->id}}' );"  value="{{$val->cupon}}"  /> 
                       
                       </td>  
                        
                      <td>
                      
                            <div class="edit_text">{{$val->amount}}</div>
                           
                           <input type="text" class="form-control data_2_get{{$val->id}} hide_edit" data-value="{{$val->amount}}"  onfocusout="save_field('{{URL::to('/')}}/admin/cupon/store', '.result{{$val->id}}', '{{$val->id}}', 'amount' , '.data_2_get{{$val->id}}' );"  value="{{$val->amount}}"  /> 
                       
                      </td>
                       <td>
                            <div class="edit_text">{{$val->type}}</div>
                           
                           <select name="type" class="form-control data_0_get{{$val->type}} hide_edit" data-value="{{$val->type}}" onchange="save_field('{{URL::to('/')}}/admin/cupon/store', '.result{{$val->id}}', '{{$val->id}}', 'type' , '.data_0_get{{$val->id}}');" >
                                <option value="fix">{{ _l('Fixed cart discount') }}</option>
                                <option value="percent" {{$val->type == 'percent'? 'selected=""': ''}}>{{ _l('Percentage cart discount') }}</option>
                           </select>
                       </td>
                       <td> {{$val->used}}</td>  
                      <td> {{$val->created_at}}</td>  
                       
                      <td> 
                         <a href="#" class="fa_edit"  onclick="edit_row_tr('#edit_this_nr{{$val->id}}');return false;"> </a>
                     </td>
                      <td> 
                        <a href="{{URL::to('/')}}/admin/cupon/destroy/{{$val->id}}" class="fa_delete" onclick="return confirm('You are sure?') ? true : false;"> </a>
                     </td>
                     <td class="result{{$val->id}}"></td>
                 </tr>
                @endforeach
             </tbody>
         </table>
 
     </div>
     {!! $rows->appends(Input::all())->render() !!}
     </form>  
 </div>
</div>
@stop