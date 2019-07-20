@extends('admin.layouts.default')

@section('title', 'Countries')
@section('content')
 
<div class="col-md-12">
 <div class="card">
    
     <div class="header">
          <h4 class="title">{{ _l('Shipping Countries or States or Regions') }}</h4>
     </div>
  <div class="add_new_top">  
    <form action="{{URL::to('/')}}/admin/setting/countries/store" method="post">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input type="hidden" name="id" value="new">
          
           <div class="col-md-2">
           <label> {{ _l('Title') }} <br />
             <input type="text" name="country" class="form-control"/>
             </label>
          </div>
         <div class="col-md-2">
          <label>{{ _l('Code') }}<br />
             <input type="text" name="code" class="form-control"/>
             </label>
          </div>
        <div class="col-md-1"><br />
           <button type="submit" class="btn btn_small">{{ _l('Add new one') }}</button>  
        </div>
         
     <div class="clear"></div>
    </form> 
   </div>   
     
     <form action="{{URL::to('/')}}/admin/setting/countries/destroy-bulk" method="post">
         <input type="hidden" name="_token" value="{{ csrf_token() }}">
           <div class="col-md-2">
             <select name="action" class="form-control" >
                <option value="">{{ _l('Action') }}</option>
                <option value="del"> {{ _l('Remove') }} </option>
            </select>
          </div>
         
        <div class="col-md-1">
           <button type="submit" class="btn btn_small">{{ _l('Apply') }}</button>  
        </div>
         
     <div class="clear"></div>
     
     <div class="content table-responsive table-full-width">
         <table class="table table-hover table-striped">
             <thead>
                 <th><input type="checkbox" id="checkall" onclick="check_all(this);" /></th>
                 <th>{{ _l('ID') }}</th>
                 <th>{{ _l('Title') }} </th>
                 <th>{{ _l('Code') }}</th>
                 <th style="width: 40px"> </th>
                 <th style="width: 40px"> </th>
             </thead>
             <tbody>
                @foreach ($rows as $val)
                   <tr> 
                     <td> <input type="checkbox" name="productid[]" class="checkboxeach"  value="{{$val->id}}"></td>
                      
                     <td>{{$val->id}}</td>
                     <td><input type="text" class="data_get{{$val->id}}" name="country" data-value="{{$val->country}}"  value="{{$val->country}}" onfocusout="save_field('{{URL::to('/')}}/admin/setting/countries/store', '.result{{$val->id}}', '{{$val->id}}', 'country' , '.data_get{{$val->id}}');" /> </td>
                     <td><input type="text" name="code"  class="data_2_get{{$val->id}}" data-value="{{$val->code}}" value="{{$val->code}}"  onfocusout="save_field('{{URL::to('/')}}/admin/setting/countries/store', '.result{{$val->id}}', '{{$val->id}}', 'code' , '.data_2_get{{$val->id}}');" /> </td>
                       
                      <td> 
                         <a href="{{URL::to('/')}}/admin/setting/countries/destroy/{{$val->id}}" class="fa_delete" onclick="return confirm('You are sure?') ? true : false;"> </a>
                     </td>
                     <td class="result{{$val->id}}"></td>
                 </tr>
                @endforeach
             </tbody>
         </table>
 
     </div>
     
     </form>  
 </div>
</div>
@stop