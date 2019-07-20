<link rel="stylesheet" media="screen" type="text/css" href="{{URL::to('/')}}/resources/admin_assets/css/colorpicker.css" />
<link href="{{URL::to('/')}}/resources/assets/css/pageBuilderDefault.css" rel="stylesheet"/>
<script src="{{URL::to('/')}}/resources/admin_assets/js/colorpicker.js"></script>
<script src="{{URL::to('/')}}/resources/admin_assets/js/edit_page.js"></script>

<style type="text/css" id="css_done"></style>
<style type="text/css" id="directCSS"></style>
<div class="main_container">
 <textarea name="text" id="editor_save" style="display: none;"></textarea>
 <textarea name="style" id="css_divs" style="display: none;">{!! @$jsondata['style'] !!}</textarea>
 
 <div class="rightSideSave">
     <a href="#" class="buttonSave cssModal"><i class="fa fa-code"></i> CSS</a>
     <button type="submit" class="buttonSave"><i class="fa fa-cloud-upload"></i> {{ _l('Save') }}</button>
 </div>
 <div class="css_editor">
     <div class="closs_editor" onclick="return closeDiv('.css_editor');">x</div>
     <textarea name="cssdirect" id="cssDirect" class="form-control">{!! @$jsondata['cssdirect'] !!}</textarea>
     
     <div class="height10px"></div>
     <div class="text_align_right">
        <a href="#" class="btn btn_small btn_active update_css">{{_l("Update")}}</a>
     </div>
 </div>
     
 
<!--  -->
<div class="editor">
     <div class="closs_editor">x</div>
      
     <textarea name="editor" class="form-control tinymce"></textarea>
     <input type="hidden" name="id_precedent" id="id_precedent" value=""/>
     <a href="#" style="margin-top: 10px;float: left;" onclick="return closeDiv('.editor');" class="btn btn_small">{{_l("Cancel")}}</a>
     <a href="#" id="save_button" style="margin-top: 10px;float: right;" class="btn btn_small btn_active">{{_l("Update")}}</a>
</div>

<!--  -->
<div class="options_windows" >
     <div class="closs_editor">x</div>
     
     <p>
        <label>{{_l("Padding")}} (Pixel) </label> 
        <div class="clear"></div>
        <div class="padding_form">
             Top 
            <input type="number" class="paddingt form-control" />
        </div>
        <div class="padding_form">
               Bottom
            <input type="number" class="paddingb form-control" />
        </div>
        <div class="padding_form">
               Left
            <input type="number" class="paddingl form-control" />
        </div>
        <div class="padding_form">
               Right
            <input type="number" class="paddingr form-control" />
        </div>
        <div class="clear"></div>
     </p>
     
     <p>
        <div style="position: relative;">
            <label>{{_l("Font Color")}} </label>
            <input type="text" class="font_color form-control" value="" />
        </div>
     </p>
     <p>
        <div style="position: relative;">
            <label>{{_l("Background Color")}} </label>
            <input type="text" class="bg_color form-control" value="" />
        </div>
     </p>
     
     <p>
        <label >{{_l("Background Image")}} </label>
         <input type="file" name="imgmain" id="background_img" onchange="upload_files('{{url('/admin/upload-simple/simple')}}', '#background_img',  '.show_result_main', '.response_main', '{{@$id}}'  );" class="load_imge_main" />
          <div class="clear_20px response_main"></div>
          <div class="show_result_main">
             <img src="" class="bg_image"  />
         </div>
         <a href="#" class="remove_image">{{_l("Remove Image")}}</a>
     </p>
     
     <p>
        <label>{{_l("Background Image Display")}} </label>
              <select class="bg_type form-control">
                 <option value="cover">Cover</option>
			     <option value="fixed">Fixed</option>
		      </select>
     </p>
       <p>
           <label>{{_l("Opacity background image ")}} </label>
               <select class="bg_opacity form-control">
                 <option value="">No opacity</option>
			     <option value="0.9">0.9</option>
                 <option value="0.8">0.8</option>
                 <option value="0.7">0.7</option>
                 <option value="0.6">0.6</option>
                 <option value="0.5">0.5</option>
                 <option value="0.4">0.4</option>
                 <option value="0.3">0.3</option>
                 <option value="0.2">0.2</option>
                 <option value="0.1">0.1</option>
               </select>
       </p>
       
       <p>
        <div style="position: relative;">
            <label>{{_l("DIV Classes")}} ({{_l("Don't touch if you don't know")}}) </label>
            <input type="text" class="div_class form-control" value="" />
        </div>
     </p>
     
     <input type="hidden" id="id_parent" value=""   />
      <a href="#" style="margin-top: 10px;float: left;" onclick="return closeDiv('.options_windows');" class="btn btn_small">{{_l("Cancel")}}</a>
     <a href="#" id="update_options" style="margin-top: 10px;float: right; " class="btn btn_small btn_active">{{_l("Update")}}</a>
    
</div>
 
      <div id="page_contents" class="postbox container_load_content">
           @if (strpos(@$content, 'dropable') !== false) 
            {!! @\Wh::check_col(@$content) !!}
           @else
              <div class="dropable sections" id="id{{rand(999999,100000)}}"> 
                {!! @\Wh::check_col(@$content) !!}
             </div>
          @endif
          
          
      </div>
</div>
   
 

 <div class="page_builder_makets">
      <div class="options_page_builder">
        <i class="fa fa-sliders" aria-hidden="true"></i>
     </div>
     
      <div class="inside_builder">
         <p>
           <label>{{_l("Add Block")}}</label> <br />
             <select class="bootstrap_blocks">
                <option value="dropable sections">{{_l('Full block')}}</option>
                <option value="clear">{{_l('Clear block')}}</option>
                @for($i=1;$i<13;$i++)
                   <option value="col-md-{{$i}}">col-md-{{$i}}</option>
                 @endfor
             </select>
            <a href="#" class="add_grid btn btn_small">Add Block</a>
            <div class="clear"></div>
             <div class="blockListPage"> 
                @include('admin.layouts.ready-blocks')
            </div>
            <a class="lodaMore_template btn" href="#" onclick=" access_url('{{url('/admin/page/check-block')}}', '.blockListPage' );return false;">Check for More</a>             
         </p>
      </div>     
 </div>
