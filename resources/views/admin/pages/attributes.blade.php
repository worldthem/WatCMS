@extends('admin.layouts.default')

@section('title', @$type_field)
@section('content')
 
 <?php
 //,'textarea'=>_l('Textarea')
 $type= ['textbox'=>_l('Textbox'),'select'=>_l('Select'),'checkbox'=>_l('Checkbox')];
 ?> 
<div class="col-md-12">
 <div class="card">
      <div class="header">
           <h4 class="title">{{@$fields}} ({{ _l('Example: Color, Size, ... ') }})</h4>
     </div>
     
       <div class="add_new_top"> 
                 <form action="{{URL::to('/')}}/admin/attributes-save" method="POST" >
                    <?php $key=\Wh::get_random(10, "yes");?>
                     <input type="hidden" name="_token" value="{{ csrf_token() }}">
                     <input type="hidden" name="id[{{$key}}]" value="{{$key}}">
                     <input type="hidden" name="field_type" value="{{@$type_field}}"> 
                    @if($input_list['title'] != 'not')
                       <div class="col-md-3">
                           <p>
                              <label>{!! $input_list['title'] !!} </label> <br/>
                              <input type="text" class="form-control" required="" name="title[{{$key}}]" value="">
                           </p>
                        </div>
                     @endif
                     @if($input_list['type'] != 'not') 
                      <div  class="col-md-3">
                           <p>
                             <label> {!! $input_list['type'] !!} </label> <br/>
                                  <select name="type[{{$key}}]"  class="form-control"> 
                                  @foreach($type as $key=>$val)
                                    <option value="{{$key}}">{{$val}}</option>
                                   @endforeach  
                                 </select>
                           </p>
                      </div>
                      @endif 
                        
                      <div  class="col-md-2">
                       <label><br /> </label> <br/>
                            <input type="submit" class="btn btn_small" value="{{ _l('Add new one') }}">
                      </div>
                  </form>
                  <div class="clear"></div>
                  </div>                 
                      <div class="clear"></div>
                  @if(!empty($data))     
                  <div class="content table-responsive table-full-width">
                  
                <form action="{{URL::to('/')}}/admin/attributes-save" method="POST" > 
                   <input type="hidden" name="_token" value="{{ csrf_token() }}">
                   <input type="hidden" name="field_type" value="{{@$type_field}}"> 
                                      
                 
                 <table class="table table-hover table-striped">
                     <thead>
                         <th style="width: 100px;">ID</th>
                         @if($input_list['title'] != 'not') 
                         <th>{{ _l('Title') }}</th>
                         @endif
                         @if($input_list['type'] != 'not')
                         <th>{{ _l('Type') }}</th> 
                         @endif
                         <th>{{ _l('ShortCode') }}</th> 
                         <th style="width: 45px;"></th>
                         <th style="width: 110px;">{{ _l('Sugestion') }}</th>
                         <th style="width: 110px;"></th>
                         <th style="width: 45px;"></th>
                     </thead>
                     <tbody> 
                           @foreach($data as $key_main=>$datas)
                              <tr id="edit_{{@$key_main}}">
                                   <td> 
                                     <input type="hidden" name="id[{{ @$key_main }}]" value="{{ @$key_main }}">
                                      {{@$key_main}} 
                                   </td>
                                   @if($input_list['title'] != 'not')
                                   <td>
                                      <div class="edit_text">{{@$datas['name']}}</div>
                                      <input type="text" class="form-control hide_edit" required="" name="title[{{ @$key_main }}]" value="{{@$datas['name']}}">
                                   </td>
                                   @endif
                                   
                                   @if($input_list['type'] != 'not')
                                   <td>
                                       <div class="edit_text">{{@$type[$datas['type']] }}</div>
                                         <select name="type[{{ @$key_main }}]" class="form-control hide_edit"> 
                                           @foreach($type as $key=>$val)
                                            <option value="{{$key}}" {{$datas['type'] ==$key? "selected":""}}>{{$val}}</option>
                                           @endforeach  
                                         </select>
                                           
                                   </td>
                                   @endif
                                    <td> [variations id={{@$key_main}} title={{@$datas['name']}}] </td> 
                                   
                                    <td> 
                                       <a href="#" class="fa_edit"  onclick="edit_row_tr('#edit_{{@$key_main}}');return false;"> </a>
                                    </td>
                                   <td>
                                      <a href="#" data-toggle="modal" data-target="#load_ajax_modal" class="btn btn_small" onclick="access_url('{{url("/admin/attributes/sugestion/".$key_main)}}','.modal_load_content');">
                                        {{ _l('Add Sugestion') }}
                                      </a>
                                     
                                   </td>
                                    
                                    <td>
                                       <input type="submit" class="btn btn_small" value="{{ _l('Save') }}"/>
                                    </td>
                                    <td> 
                                       <a href="{{URL::to('/')}}/admin/attributes-delete/{{@$type_field}}/{{$key_main}}" title="Delete"  class="fa_delete">  </a>
                                    </td>
                                </tr> 
                           @endforeach 
                      </tbody>
                    </table> 
                 </form> 
               </div>
               @endif   
               
         <div class="clear"></div>            
    </div>
</div>
 
 
 
 
@stop