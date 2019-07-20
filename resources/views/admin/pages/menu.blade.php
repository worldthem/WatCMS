@extends('admin.layouts.default')

@section('title', 'Menu')
@section('content')
 
<div class="col-md-12">
 <div class="card">
       
         <div class="header">
           <h4 class="title">{{ _l('Menu') }}</h4>
        </div>
     <div class="add_new_top">  
    <form action="{{URL::to('/')}}/admin/menu/store" method="post">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input type="hidden" name="id" value="new">
         
           <div class="col-md-2">
             <label> {{ _l('Menu Name') }} <br />
                <input type="text" name="value" required="" class="form-control"/>
             </label>
          </div>
          
         <div class="col-md-1"><br />
           <button type="submit" class="btn btn_small">{{ _l('Add New') }} </button>  
        </div>
         
     <div class="clear"></div>
    </form> 
   </div> 
      
        
     <div class="content table-responsive table-full-width">
         <table class="table table-hover table-striped">
             <thead>
                 <th>ID</th>
                 <th>{{ _l('Menu Name') }}</th>
                 <th>{{ _l('Use menu in code') }} </th>
                 <th>{{ _l('Use menu  in page') }}</th>
                 <th style="width: 40px"> </th>
                 <th style="width: 40px"> </th>
             </thead>
             <tbody>
                @foreach ($rows as $val)

                 <tr id="edit_this_nr{{$val->id}}"> 
                       <td>{{$val->id}}</td>
                       <td>
                            {{$val->value}} 
                       </td>  
                      <td>
                      
                       &lt;ul class ="your_class"&gt;
                       {{ !empty($val->value2) ? '@{!! \Wh::get_menu("'.$val->value2.'") !!}':'@{!! \Wh::get_menu("'.$val->id.'") !!}'   }}  
                       &lt;/ul&gt;
                     </td>
                      <td>[menu id={{$val->id}} class=your_class]</td>
                      <td> 
                         <a href="{{URL::to('/')}}/admin/menu/single/{{$val->id}}" class="fa_edit small" > </a>
                     </td>
                      <td> 
                        <a href="{{URL::to('/')}}/admin/menu/destroy/{{$val->id}}" class="fa_delete" onclick="return confirm('You are sure?') ? true : false;"> </a>
                     </td>
                     <td class="result{{$val->id}}"></td>
                 </tr>
                @endforeach
             </tbody>
         </table>
 
     </div>
    
 </div>
</div>
@stop