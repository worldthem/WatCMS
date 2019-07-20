@extends('admin.layouts.default')

@section('title', $row->value)

@section('content')

 <script src="{{URL::to('/')}}/resources/admin_assets/js/jquery.mjs.nestedSortable.js"></script>
 <script src="{{URL::to('/')}}/resources/admin_assets/js/menu.js"></script>
  
 
 <div class="col-md-12">
    
       <div class="col-md-12">
         <h3>{{$row->value}}</h3>
      </div>
       
       <div class="col-sm-4">
         <div class="card">
          <div class="block">
            <h3 class="header_block menu_open">{{ _l('Custom Link') }}</h3> 
            <div class="paddinginside block_inside active">
                  <label class="col-md-4">{{ _l('Select Icon') }}</label> 
                   <div class="col-md-8">
                     <button type="button" class="icon_link" onclick="icon_setup('.link_text',this)" data-toggle="modal" data-target="#load_icons_modal" >Select icon</button>
                   </div>
                   <div class="height10px"></div>
                   
                  <label class="col-md-4">{{ _l('Select URL') }}</label> 
                  <div class="col-md-8">
                    <select name="" class="form-control" onchange="select_url_fromlist(this,'.link_text_href','.link_text')">
                       @foreach($custom_links as $k=>$v)
                        <option value="{{$k}}">{{$v}}</option>
                       @endforeach 
                    </select>
                  </div>
                  <div class="height10px"></div>
                 <label class="col-md-4">{{ _l('Or enter manually') }}</label> 
                  
                  <div class="col-md-8">
                   <input type="text" value="" placeholder="#" name="link" class="form-control link_text_href" />
                 </div>
                  
                 
                  <div class="height10px"></div>
                  <label class="col-md-4">{{ _l('Menu name') }}</label> 
                  <div class="col-md-8">
                    <input type="text" value="" placeholder="Home" name="link" class="form-control col-md-8 link_text" data-icons="" />
                  </div>
                  
                  <div class="height10px"></div>
                  <p class="col-md-12 text_align_right">
                   <a href="#" class="btn btn_small" onclick="return simple_link('.link_text','text');">{{ _l('Add ittem') }}</a>
                  </p>
                  <div class="clear"></div> 
             </div>
          </div>
          
          <div class="block">
            <h3 class="header_block menu_open">{{ _l('Pages') }}</h3> 
             <div class="paddinginside block_inside">
                   <label class="col-md-4">{{ _l('Select Icon') }}</label> 
                   <div class="col-md-8">
                     <button type="button" class="icon_pages" onclick="icon_setup('.link_page',this)" data-toggle="modal" data-target="#load_icons_modal" >{{ _l('Select icon') }}</button>
                   </div>
                   
                   <div class="height10px"></div>
             
                <label class="col-md-4">Page</label> 
                   <div class="col-md-8">
                     <select class="form-control link_page" data-icons="">
                      @foreach($pages as $p)
                        <option value="{{ '/page/'.$p->cpu }}" data-info="page_{{$p->id}}" >{{trim($p->title)}}</option>
                      @endforeach 
                     </select>
                  </div>
                  <div class="height10px"></div>
                 <p class="col-md-12 text_align_right">
                   <a href="#" class="btn btn_small" onclick="return simple_link('.link_page', '.page_icon');">Add ittem</a>
                  </p> 
                  <div class="clear"></div>
             </div>
            </div>
             <?php $array_cat_type = \Wh::mergeConstantAnConfig(CATEGORIES_TYPES,'categoriesType'); ?>    
             
          @foreach($array_cat_type as $k_list => $cat_list)
             @foreach($cat_list as $k1=>$v1)
               <?php 
                  $class1=\Wh::get_random(15,"n");
                  $class2=\Wh::get_random(15,"n");
                  $url_is = $k_list =="product" ? "/cat" : "/category/".$k1;
                ?>
               <div class="block">
                <h3 class="header_block menu_open">{{ $v1 }}</h3> 
                 <div class="paddinginside block_inside">
                      
                       <label class="col-md-4">{{ _l('Select Icon') }}</label> 
                       <div class="col-md-8">
                         <button type="button" class="{{$class1}}" onclick="icon_setup('.{{$class2}}',this)" data-toggle="modal" data-target="#load_icons_modal" >{{ _l('Select icon') }}</button>
                       </div>
                       
                       <div class="height10px"></div>
                
                    <label class="col-md-4">{{ _l('Select') }}</label> 
                     <div class="col-md-8">
                       <select class="form-control {{$class2}}" data-icons="">
                          {!! \Wh::get_cat_yerahical_option(\Wh::getAllCategories_all($k1), 0, 0, $url_is) !!}
                       </select>
                     </div>
                     <div class="height10px"></div>
                     <p class="col-md-12 text_align_right">
                       <a href="#" class="btn btn_small"  onclick="return simple_link('.{{$class2}}');">{{ _l('Add ittem') }}</a>
                      </p> 
                  <div class="clear"></div>
                 </div>
                </div> 
              @endforeach  
           @endforeach
          
          </div>
         
         
          
       </div>
       
       <div class="col-sm-8">
       <form action="{{URL::to('/')}}/admin/menu/store" method="post" enctype="multipart/form-data">
                
         <div class="card"> 
              <div class="header_block"> 
                    <div class="col-md-10 header_menue">
                      
                       <em>{{ _l('Menu name') }}:</em>
                       <input type="text" name="value" value="{{ $row->value }}" class="form-control small_input"  />
                           @if(!empty($position)) 
                            <em>{{ _l('Position') }}:</em>
                               <select name="value2" class="form-control small_input">
                                    <option>{{_l("Select Position")}}</option>
                                   @foreach($position as $k_position=>$v_position)
                                    <option value="{{@$k_position}}" {{ $row->value2==@$k_position ? 'selected=""':'' }} >{{_l(@$v_position)}}</option>
                                   @endforeach 
                              </select>
                          @endif   
                     </div> 
                    <div class="col-md-2 text_align_right">
                      <input type="submit" class="btn btn_small submit_form" value="{{ _l('Update') }}"/>
                   </div>
                   <div class="clear"></div>
                  </div>
         <div class="paddinginside">
            
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  <input type="hidden" name="id" value="{{ $row->id }}">
                  
                  <textarea name="value1" id="response" style="display: none;"></textarea>
                   
                <div class="menu-box"> 
                 <ul class="menu-list sortable">
                    {!! $row->value1 !!}
                 </ul>
              </div>
               
            
         </div>  
       </div>
        </form>
     </div>      
         <div class="height20px"></div>
 </div>
 
  <div class="edit_link_div">
                 <input  type="hidden" value="" class="link_edit_hidden_href"/>
                  
                  
                   <label class="col-md-4">{{ _l('Select Icon') }}</label> 
                   <div class="col-md-8">
                     <button type="button" class="icon_link_edit" onclick="icon_setup('.link_edit_text',this)" data-toggle="modal" data-target="#load_icons_modal" >{{ _l('Select icon') }}</button>
                   </div>
                   <div class="height10px"></div>
                   
                  <label class="col-md-4">{{ _l('Select URL') }}</label> 
                  <div class="col-md-8">
                    <select name="" class="form-control" onchange="select_url_fromlist(this, '.link_edit_href','.link_edit_text')">
                      @foreach($all_list as $k=>$v)
                        <option value="{{$k}}">{{$v}}</option>
                       @endforeach
                    </select>
                  </div>
                  
                  <div class="height10px"></div>
                 
                 <label class="col-md-4">{{ _l('Or enter manually') }}</label> 
                  
                  <div class="col-md-8">
                   <input type="text" value="" placeholder="#" name="link" class="form-control link_edit_href" />
                 </div>
                  
                 
                  <div class="height10px"></div>
                  <label class="col-md-4">{{ _l('Menu name') }}</label> 
                  <div class="col-md-8">
                    <input type="text" value="" placeholder="Home" name="link" class="form-control col-md-8 link_edit_text" data-icons="" />
                  </div>
                  
                  <div class="height10px"></div>
                  <p class="col-md-12 text_align_right">
                  <a href="#" class="btn btn_small close_edit_div" >Close</a>
                   <a href="#" class="btn btn_small" onclick="return simple_link_update('.link_edit_text','text');">{{ _l('Update') }}</a>
                  </p>
                  <div class="clear"></div> 
             
    
  </div>
 
@stop 