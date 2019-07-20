@extends('admin.layouts.default')
@section('title', @$fields['title'])
@section('content')
<div class="col-md-12">
 <div class="card">
    
      <?php 
         $settings= @json_decode(\Wh::get_settings($type, "value1"),true);
       ?>     
   
     <form action="{{URL::to('/')}}/admin/setting/standart/store" method="post">
       <input type="hidden" name="_token" value="{{ csrf_token() }}">
       <input type="hidden" name="action_field" value="{{$type}}">
        <div class="col-md-6">
           <h3> {{$fields['title']}}</h3> 
        </div>
        <div class="col-md-6 text_align_right">
          <input type="submit" class="btn btn_small" value=" {{ _l('Update') }}"/>
       </div>
       <div class="col-md-12 text_align_right">
        <a href="#" class="btn btn_small btn_active" onclick="option_enabled(); return false;"> {{ _l('Active Options') }}</a> | <a href="#" class="btn btn_small" onclick="option_all(); return false;"> {{ _l('All options') }}</a>
       </div>
        
       <div class="content table-responsive table-full-width">
          <table class="table table-hover table-striped">
              <tbody>
                  <?php unset($fields['title']); ?>
                   @include('admin.layouts.table_inner', ['fields' => $fields,'settings'=>$settings ])
             </tbody>
         </table>
       </div>
        <div class="col-md-12 text_align_right">
          <input type="submit" class="btn btn_small" value=" {{ _l('Update') }}"/>
        </div>
        <div class="height15px"></div>
     </form>
      
  
   </div>
 
  </div>
 
@stop