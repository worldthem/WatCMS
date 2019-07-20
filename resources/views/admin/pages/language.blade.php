@extends('admin.layouts.default')

@section('title', 'Language')
@section('content')
 <?php 
   $lang_admin = $lang_admin ?? '';
   $lang_view = $lang_view ?? '';
 ?>
<div class="col-md-12">
 <div class="card">
       
         <div class="header">
           <h4 class="title">{{ _l('Language') }}</h4>
        </div>
     <div class="add_new_top">  
    <form action="{{URL::to('/')}}/admin/general-settings/language/set" method="post">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input type="hidden" name="id" value="new">
         
              <div class="col-md-3">
                <i class="fa fa-flag"></i> {{ _l("Front end Language") }}<br />
                <select name="_lang_view_" class="form-control">
                  <option value="">{{ _l('Select') }}</option>
                     @foreach($lang as $k1=>$v_lang)
                       <option value="{{ $k1 }}" {{$lang_view ==$k1 ? 'selected=""':'' }} >{{ $v_lang }}</option>
                     @endforeach                                           
                 </select>
             </div>
          
            <div class="col-md-3">
                 <i class="fa fa-flag"></i> {{ _l("Admin Language") }}<br />
                 <select name="_lang_admin_" class="form-control">
                  <option value="">{{ _l('Select') }}</option>
                     @foreach($lang as $k2=>$v_lang)
                       <option value="{{ $k2 }}" {{$lang_admin ==$k2 ? 'selected=""':'' }} >{{ $v_lang }}</option>
                     @endforeach                                           
                 </select>
             </div>
          
         <div class="col-md-2"><br />
           <button type="submit" class="btn btn_small">{{ _l('Change') }} </button>  
        </div>
         
     <div class="clear"></div>
    </form> 
   </div> 
      
  @if(!empty($lang_view) && $lang_view !='en' || !empty($lang_admin) && $lang_admin !='en')  
     <div class="content table-responsive table-full-width">
      <form action="{{URL::to('/')}}/admin/general-settings/language/store" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="langView" value="{{ @$lang_view }}">
        <input type="hidden" name="langAdmin" value="{{ @$lang_admin }}">
        
          <div class="rightSideSave">
            <button type="submit" class="buttonSave"><i class="fa fa-cloud-upload"></i> {{ _l('Save') }}</button>
         </div>
          
         <table class="table table-hover table-striped">
             <thead>
                 <th style="width: 33%;">{{ _l('In English') }}</th>
                  @if(!empty($lang_view) && ($lang_view != 'en') )   
                    <th>
                    <a href="#" class="shareTranslate lang1Share" onclick="access_url('{{url('/admin/language/shareTranslate/'.@$lang_view)}}', '.lang1Share' ); return false;">
                          Share This Translate
                    </a><br />
                      {{ _l('In').' '.@$lang[$lang_view] }} 
                        <a href="{{url('/admin/language/translate/'.$lang_view)}}" class="btn btn_small">
                           <i class="fa fa-plus" aria-hidden="true"></i>
                       </a>
                       
                    </th>
                  @endif 
                   
                 @if(!empty($lang_admin) and ($lang_admin != 'en'))  
                  <th>  
                         <a href="#" class="shareTranslate lang2Share" onclick="access_url('{{url('/admin/language/shareTranslate/'.($lang_admin ?? ''))}}', '.lang2Share' ); return false;">
                          Share This Translate
                        </a><br />
                        {{ _l('In').' '. ($lang[$lang_admin] ?? '') }} 
                          <a href="{{url('/admin/language/translate/'.($lang_admin ?? ''))}}" class="btn btn_small">
                             <i class="fa fa-plus" aria-hidden="true"></i>
                          </a>
                  </th> 
                 @endif 
             </thead>
             
             <tbody>
                 @foreach ($rows as $val)
                     <tr>
                        <td>{{$val}}</td> 
                        @if(!empty($lang_view) && ($lang_view != 'en'))  
                            <td>
                              <input  type="text" class="form-control" name="dataView[{{$val}}]" value="{{ !empty($translateView[$val])? $translateView[$val]:''}}"/>
                            </td>
                         @endif 
                        
                        @if( !empty($lang_admin) && ($lang_admin != 'en'))  
                            <td>
                              <input  type="text" class="form-control" name="dataAdmin[{{$val}}]" value="{{ @$translateAdmin[$val] }}"/>
                            </td>
                        @endif  
                     </tr>
                 @endforeach
             </tbody>
         </table>
       </form> 
     </div>
   @endif 
 </div>
</div>
 
@stop