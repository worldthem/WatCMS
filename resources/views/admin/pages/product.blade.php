@extends('admin.layouts.default')

@section('title', !empty($page)? _l("Edit:").$page->title :_l("Add new Product") )
@section('content')

@if(!empty($settings_attributes))

     @include('admin.layouts.autocomplete')
    
    <div id="new_element_is"  style="display: none;">
       @include('admin.layouts.variation_fields', ['variation' => [] ])
    </div>
    
 @endif
 
 <?php 
 $meta =  @json_decode(@$page->meta,true) ;
 $optionsdata =  @json_decode(@$page->optionsdata,true) ;
 ?>   
    {!! \Wh::sucessSavedMsg() !!}
 
 <form action="{{URL::to('/')}}/admin/product-save" method="POST" >
  <div class="col-md-9 productSingle">
            <div class="card">
                <div class="header">
                  <h4 class="title"> {{ !empty($page)? _l("Edit:").$page->title :_l("Add new Product") }} </h4>
                </div>

                <div class="content">
                   
                     <input type="hidden" name="_token" value="{{ csrf_token() }}">
                     <input type="hidden"  id="parent_id" name="id" value="{{@$id}}">
                     <div  class="col-md-6">
                           <p>
                             <label> {{ _l('Title') }} </label> <br/>
                             <input type="text" class="form-control" name="title" value="{{@$page->title}}">
                          </p>
                      </div>
                     <div  class="col-md-6">
                        <p>
                            <label>{{ _l('CPU') }}  </label> <br/>
                            <input type="text" class="form-control" name="cpu" value="{{@$page->cpu}}">
                        </p>
                     </div>
                     
                         <div class="col-md-6">
                             <p>
                                <label>{{ _l('Meta description') }} </label> <br/>
                                <input type="text" class="form-control" name="metad" value="{{@$meta['metad'] }}">
                             </p>
                        </div>
                         <div  class="col-md-6">
                            <p> <label>{{ _l('Meta keyword') }} </label> <br/>
                               <input type="text" class="form-control" name="metak" value="{{@$meta['metak'] }}">
                            </p>
                         </div>
                      
                      
                   <div class="clear"></div>
                   <div class="col-md-2">
                          <p>
                            <label>{{ _l('Stock') }}</label> <br/>
                             <select name="stock">
                               <option  value="1" {{@$optionsdata['stock'] === 1 ? 'selected=""':'' }}>{{ _l('In stock') }}</option>
                               <option value="0" {{@$optionsdata['stock'] === 0 ? 'selected=""':'' }}>{{ _l('Out of stock') }}</option>
                             </select>
                          </p>
                      </div>
                       
               
                       <div class="col-md-2">
                          <p>
                            <label>{{ _l('Price') }} </label> <br/>
                            <input type="text" class="form-control" name="price" value="{{@number_format(@$page->price, 2, '.', '')}}">
                          </p>
                      </div>
                       <div class="col-md-2">
                        <p>
                            <label>{{ _l('Sale price') }} </label> <br/>
                            <input type="text" class="form-control" name="sale_price" value="{{@number_format(@$page->sale_price, 2, '.', '')}}">
                        </p>
                     </div>
                     
                      <div class="col-md-2">
                        <p>
                            <label>{{ _l('SKU') }} </label> <br/>
                            <input type="text" class="form-control" name="SKU" value="{{@$page->SKU}}">
                        </p>
                     </div>
                     <div class="col-md-2">
                        <p>
                            <label>{{ _l('Quantity') }} </label> <br/>
                            <input type="text" class="form-control" name="qtu" value="{{@$page->qtu}}">
                        </p>
                     </div>
                     <div class="col-md-2">
                          <p>
                            <label>{{ _l('Weight') }}(KG) </label> <br/>
                            <input type="text" class="form-control" name="weight" value="{{@number_format(@$page->weight, 2, '.', '')}}">
                          </p>
                     </div>
                     
                  
                   <div class="clear"></div>
                 <div class="block_attributes">   
                    <a class="title_attributes" href="{{URL::to('/')}}/admin/attributes/variations" target="_blank">Add / Edit Variation <i class="icon_result fa fa-plus"></i> </a> 
                    
                     <div class="clear"> </div> 
                     
                     <div id="variation_control"> 
                         @if(!empty($settings_attributes['variations']) && !empty($attributes['variation']))
                            <?php $jj = 0;?>
                             @foreach($attributes['variation'] as $variation)
                                 @include('admin.layouts.variation_fields',compact('variation','jj'))
                               <div class="clear"></div> 
                                <?php $jj ++;?>  
                             @endforeach
                         @endif
                    </div>
                       @if(!empty($settings_attributes['variations']))
                           <a href="#" onclick="return new_element_add(); " title="{{ _l('Add new Variation') }}" class="fa_add float_right"></a> 
                       @endif
                         <div class="clear"> </div>
                  </div> 
                    
                    
                         <div class="background_variation">
                             <div  class="col-md-5">
                                <p>
                                    <label>{{ _l('File Title') }}:</label> <br/>
                                    <input type="text" class="form-control" id="downloadable_title" name="upload_title">
                                     <small><i>If product is virtual and Downloadable</i></small>
                                </p>
                             </div>
                             
                             <div  class="col-md-4">
                                <p>
                                    <label>{{ _l('Select file') }}:</label> <br/>
                                    <input type="file" class="form-control" id="downloadable" name="upload_file">
                                    <small><i>{{ _l('Costomer will get access after order') }}</i></small>
                                </p>
                             </div>
                          
                              <div  class="col-md-3">
                                  <p><label><br/></label> <br/>
                                    <input  type="button" class="btn btn_small" value="Upload" onclick="upload_files('{{URL::to('/')}}/admin/product/upload-file', '#downloadable',  '.listOfFiles', '.load_iacon', '{{@$id}}', '#downloadable_title');"/>
                                     <span style="float: right;" class="load_iacon"></span>
                                  </p>
                              </div>
                              
                                <div class="clear"></div>
                              <div class="listOfFiles">
                                 {!! \Wh::get_admin_files(@$id) !!}
                              </div>
                              
                              <div class="clear"></div>
                        </div>
                      <div class="height10px"></div>
                      <div class="block_attributes">   
                    <a class="title_attributes" href="{{URL::to('/')}}/admin/attributes/specifications" target="_blank">Add / Edit Specification <i class="icon_result fa fa-plus"></i></a></h4>
                      
                     @if(!empty($settings_attributes['specifications']))
                          <?php  $data_spec= @$attributes['specification']; ?>
                      @foreach($settings_attributes['specifications'] as $key_spec => $spec)
                          
                          
                          @if($spec['all']['type']=='textarea')
                              <div class="col-xs-12">
                                <label> {{@$spec['all']['name']}} </label> <br />
                               <textarea class="form-control tinymce" name="specification[{{$key_spec}}]">{{@$data_spec[$key_spec]}}</textarea>
                               <div class="height10px"></div>
                             </div>
                             @elseif($spec['all']['type']=='select')
                             <div class="col-xs-6">
                                  <label> {{@$spec['all']['name']}} </label> <br />
                                <select class="form-control" name="specification[{{@$key_spec}}]">
                                      <option value="">{{ _l('Select') }}</option>
                                      @foreach(@$spec['sugestion'] as $k=>$sugestion)
                                         <option value="{{@$sugestion}}" {{ @$data_spec[$key_spec]==$k ? "selected":"" }}>{{@$sugestion}}</option>
                                     @endforeach
                                </select>
                             </div>
                                
                             
                             
                             @elseif($spec['all']['type']=='checkbox')
                             <div class="clear"></div>
                               <h4>{{@$spec['all']['name']}}</h4>
                                 
                                 
                              @foreach(@$spec['sugestion'] as $kSugestion=> $sugestion)
                                    <div class="col-md-2">
                                        <label> 
                                         <input type="checkbox" name="specification[{{@$key_spec}}][]" value="{{@$sugestion}}" {{\Wh::checkArrayIs($data_spec, $key_spec, $kSugestion) ? "checked":"" }}  /> 
                                             {{$sugestion}} 
                                       </label>
                                    </div>
                               @endforeach  
                              <div class="height10px"></div>
                              
                             @else
                             <div class="col-xs-6">
                                  <label> {{@$spec['all']['name']}} </label> <br />
                                 <input type="text" class="form-control wsugestion" data-name="{{@$key_spec}}" name="specification[{{@$key_spec}}]" autocomplete="off" value="{{@$spec["sugestion"][@$data_spec[$key_spec]]}}">
                                 <div class="sugestion_elements"></div>
                             </div>  
                             @endif
                           
                       
                        @endforeach
                        
                    @endif
                    <div class="clear"></div>
                    </div>
                     <div class="height10px"></div>
                    <div class="col-md-12">
                    <label> {{ _l('Small Description') }}</label>
                        <textarea name="description" id="editor" class="form-control tinymce">{{@$page->description}}</textarea>
                    </div>
                    <div class="height20px"></div>
                      <div class="col-md-12">
                        <label> {{ _l('Full Description') }}  </label>
                        <textarea name="text" id="editor" class="form-control tinymce">{{@$page->text }}</textarea>
                      </div>
                    <div class="height10px"></div>
                     
                     <div  class="col-md-6">
                        <p>
                            <label>{{ _l('External URL') }} </label> <br/>
                            <input type="text" class="form-control" name="cpu_store" value="{{@$optionsdata['cpu_store']}}">
                        </p>
                     </div>
                     
                   <div class="height10px"></div>
                 </div>
            </div>
 </div>
  <div class="col-md-3">
       
       <div class="card padding_10px">
           <h3 class="margin_top_0px">{{ _l('Publish') }}</h3>
           <button type="submit" class="btn"> Save </button>
       </div>
   <?php $array_cat_type =\Wh::mergeConstantAnConfig(CATEGORIES_TYPES,'categoriesType');
         $foreach_list = @$array_cat_type['product'];
         $cat = @array_filter(json_decode(@$page->cat,true));
      ?>    
     @include('admin.layouts.selectCategory',compact('array_cat_type','foreach_list','cat'))
     
  
       <div class="card padding_10px">
         <h3 class="margin_top_0px">{{ _l('Main Images') }}</h3>
         <input type="file" name="imgmain" id="load_imge_main" onchange="upload_files('{{URL::to('/')}}/admin/upload-image/main', '#load_imge_main',  '.show_result_main', '.response_main', '{{@$id}}'  );" class="load_imge_main" />
         <div class="clear_20px response_main"></div>
         <div class="show_result_main">
                {!! @\Wh::return_main_image( $optionsdata['image'] ) !!}
          <div class="clear"></div>   
         </div>
      </div>   
  
      <div class="card padding_10px">
         <h3 class="margin_top_0px">{{ _l('Gallery') }}</h3>
         <input type="file" name="gallery" id="load_imge_gallery" multiple="" onchange="upload_files('{{URL::to('/')}}/admin/upload-image/gallery', '#load_imge_gallery',  '.show_result_gallery', '.response_gallery', '{{@$id}}'  );" class="load_imge_galery" />
         <div class="clear_20px response_gallery"></div>
         <div class="show_result_gallery"  >
            {!! \Wh::get_admin_gallery(@$id) !!}
         </div>
      </div>
  
    
  
  </div>  
 </form>  
 <script src="{{URL::to('/')}}/resources/admin_assets/js/variation-product.js"></script>  
  
@stop