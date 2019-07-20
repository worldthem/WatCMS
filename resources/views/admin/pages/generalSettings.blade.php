@extends('admin.layouts.default')

@section('title', _l('General Settings'))
@section('content')
 <?php
  $general = _GENERAL_SETTINGS;
  $crop_media = \Wh::constant_key(_MAIN_OPTIONS_, "_media_crop");
 ?> 
   <div class="col-md-12">
   <div class="card">
      
   
        <div class="col-md-12">
          <h3>{{ _l('General Settings') }}</h3>
       </div>
       
        <form action="{{URL::to('/')}}/admin/general-settings/store" method="post" enctype="multipart/form-data">
             <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="col-md-12 text_align_right">
               <input type="submit" class="btn btn_small" value="{{ _l('Update') }}"/>
             </div>
              <div class="col-md-6">  
                 <table  class="table_admin_settings">
                   <tr>
                         <th> 
                           <i class="fa fa-file-picture-o"></i> {{ _l('Logo') }}
                         </th>
                         <td> 
                            <div class="col-md-12">
                                   <input type="file" class="form-control" name="_logo_"  />
                                 @if(@\Wh::constant_key(_MAIN_OPTIONS_,  "_logo_"))
                                   <img src="{{ url("/public/img")."/". @\Wh::constant_key(_MAIN_OPTIONS_,  "_logo_") }}" style="max-height: 70px;"/>
                                 @endif
                              </div>  
                         </td>
                     </tr>
                     <tr>
                         <th> 
                           <i class="fa fa-file-picture-o"></i> {{ _l('Favicon') }}
                         </th>
                         <td> 
                            <div class="col-md-12">
                               <input type="file" class="form-control" name="_favicon_"  />
                             
                               @if(@\Wh::constant_key(_MAIN_OPTIONS_,  "_favicon_"))
                               <img src="{{ url("/public/img")."/". @\Wh::constant_key(_MAIN_OPTIONS_,  "_favicon_") }}" style="max-width: 40px;"/>
                               @endif
                            </div>  
                         </td>
                     </tr>
                     
                      <tr>
                         <th> 
                           <h4>{{_l('Media')}}:</h4> 
                         </th>
                         <td> 
                               
                         </td>
                     </tr>
                      <tr>
                          <th> 
                           <i class="fa fa-file-picture-o"></i> {{ _l('Crop image by dimension') }}
                         </th>
                         <td> 
                             <div class="col-sm-12">
                             <label class="switch">
                                <input type="checkbox" class="checkbox" {{$crop_media == 'yes'? 'checked=""':'' }} name="_main_options_[_media_crop]" value="yes" />
                                <span class="slider round"></span>
                              </label>
                           </div>
                         </td>
                     </tr>
                      <tr>
                          <th> 
                           <i class="fa fa-file-picture-o"></i> {{ _l('Thumbnail size') }} (pixel)                         </th>
                         <td> 
                             <div class="col-sm-6">
                                 <input type="text" class="form-control" placeholder="255" name="_main_options_[_media_width]" value="{{ \Wh::constant_key(_MAIN_OPTIONS_, "_media_width") }}" />
                            </div>
                              <div class="col-sm-6">
                                 <input type="text" class="form-control" placeholder="383" name="_main_options_[_media_height]" value="{{ \Wh::constant_key(_MAIN_OPTIONS_, "_media_height") }}" />
                             </div>   
                         </td>
                     </tr>
                     
                </table>
              </div>
              
               <div class="col-md-6">  
                 <table  class="table_admin_settings">
                      @foreach($general as  $k=>$v)
                        @include('admin.layouts.generalSettings')
                      @endforeach 
                </table>
              </div>
             
            <div class="col-md-12 text_align_right">
               <input type="submit" class="btn btn_small" value="{{ _l('Update') }}"/>
           </div>  
         </form>  
         <div class="height20px"></div>
      </div>
  </div>
      

@stop     