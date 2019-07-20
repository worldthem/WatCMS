@extends('admin.layouts.default')

@section('title', !empty($page->id)? _l('Edit:').@$page->title : _l('Add new one'))
@section('content')
{!! \Wh::sucessSavedMsg() !!}
   <form action="{{URL::to('/')}}/admin/page/save" method="POST"  class="updateFormPage">
     <input type="hidden" name="_token" value="{{ csrf_token() }}">
     <input type="hidden" name="id" value="{{@$page->id}}">
     <input type="hidden" name="type" value="{{@$type}}">
     
                     <div class="col-md-{{@$type != "pages" ? "9": "12"}}">
                        <div class="card">
                              <div class="header">
                                <h4 class="title"> {{ !empty($page)? "Edit:".$page->title :"Create new page" }} </h4>
                              </div>
                            
                              
                            <div class="content">
                                  @if(in_array('enable',$post_type[@$type]))
                                    <div  class="col-md-6">
                                      <p>
                                        <label>{{ _l('Enable/Disable') }} </label> <br/>
                                        <input type="checkbox" {{@$jsondata['enable']=='enable'? 'checked=""':''}}  name="enable" value="enable">
                                      </p>
                                    </div> 
                                    <div class="clearfix"></div>
                                   @endif  
                                   
                                   <div  class="col-md-6">
                                      <p>
                                        <label>{{ _l('Title') }} </label> <br/>
                                        <input type="text" class="form-control" name="title" value="{{@$page->title}}">
                                      </p>
                                   </div>
                                    
                                  @if(in_array('cpu',$post_type[@$type]))
                                   <div  class="col-md-6">
                                      <p>
                                        <label>{{ _l('CPU') }} </label> <br/>
                                        <input type="text" class="form-control" name="cpu" value="{{@$page->cpu}}">
                                      </p>
                                   </div> 
                                   @endif
                                    @if(in_array('sort',$post_type[@$type]))
                                   <div  class="col-md-6">
                                      <p>
                                        <label>{{ _l('Order') }} </label> <br/>
                                        <input type="text" class="form-control" name="sort" value="{{@$page->sort}}">
                                      </p>
                                   </div> 
                                   @endif
                                   @if(in_array('metad',$post_type[@$type]))
                                   <div  class="col-md-6">
                                      <p>
                                        <label>{{ _l('Meta description') }} </label> <br/>
                                        <input type="text" class="form-control" name="metad" value="{{@$jsondata['metad']}}">
                                      </p>
                                   </div> 
                                  @endif
                                   @if(in_array('metak',$post_type[@$type]))
                                   <div  class="col-md-6">
                                      <p>
                                        <label>{{ _l('Meta keyword') }} </label> <br/>
                                        <input type="text" class="form-control" name="metak" value="{{@$jsondata['metak']}}">
                                      </p>
                                   </div> 
                                    @endif
                                   @if(in_array('subject',$post_type[@$type]))
                                   <div  class="col-md-6">
                                      <p>
                                        <label>{{ _l('Subject') }} </label> <br/>
                                        <input type="text" class="form-control" name="subject" value="{{@$jsondata['subject']}}">
                                      </p>
                                   </div> 
                                    @endif
                                               
                                <div class="height10px"></div>
                                  {!! \Wh::hooks("page_edit_add") !!}
                                <div class="height10px"></div>
                                
                                <div class="col-md-12">
                                   @if($type=="emails") 
                                     <h3>{{_l("Replace this short code with your need")}}:</h3><br />
                                     <b>[order_number]</b>  - {{_l("This will show the order number")}} <br />
                                     <b>[products]</b>  - {{_l("Product List")}} <br />
                                     <b>[billing_shiping]</b> - {{_l("Billing information")}} <br />
                                     <b>[order_amount]</b> - {{_l("Total order ammount")}}<br />
                                     <b>[first_name]</b> - {{_l("Billing first name")}} <br />
                                     <b>[last_name]</b> - {{_l("Billing last name")}} <br /><br />
                                     {{_l("This is for new account and reset password")}}<br />
                                     <b>[email]</b> - {{_l("User Login(email)")}}<br />
                                     <b>[reseturl]</b> - {{_l("Reset Link (for reset password)")}}<br />
                                    @endif
                                    
                                    @if($type!="pages")
                                      <textarea name="text" id="editor" class="form-control tinymce">{{@$page->text}}</textarea>
                                    @else
                                      @include('admin.layouts.page-editor', ['content' => @$page->text ])
                                    @endif
                                </div>
                                <div class="height10px"></div>
                                  <div class="text-center">
                                    <input type="submit" class="btn save_content btn_active" value="{{ _l('Save') }}"/>
                                 </div>
                                <div class="height30px"></div>
                            </div>
                        </div>
                    </div>
                    
                    @if($type!="pages")
                    <div class="col-md-3">
       
                              <div class="card padding_10px">
                                <h3 class="margin_top_0px">{{ _l('Publish') }}</h3>
                                <button type="submit" class="btn"> Save </button>
                             </div>
                           
                     @if(in_array('cat',$post_type[@$type]))      
                          <?php $array_cat_type =\Wh::mergeConstantAnConfig(CATEGORIES_TYPES,'categoriesType');
                                $foreach_list = @$array_cat_type['posts'];
                                $cat = @array_filter(json_decode(@$page->cat,true));
                             ?>    
                        
                         @include('admin.layouts.selectCategory',compact('array_cat_type','foreach_list','cat'))
                          
                      @endif 
                      
                      
                      
                      @if(in_array('image',$post_type[@$type]))
                          <div class="card padding_10px">
                             <h3 class="margin_top_0px">{{ _l('Image') }}</h3>
                             <input type="file" name="imgmain" id="load_imge_main" onchange="upload_files('{{url('/admin/upload-image/main')}}', '#load_imge_main',  '.show_result_main', '.response_main', '{{@$id}}'  );" class="load_imge_main" />
                             <div class="clear_20px response_main"></div>
                             <div class="show_result_main">
                                    {!! @\Wh::return_main_image( $jsondata['image'] ) !!}
                              <div class="clear"></div>   
                             </div>
                          </div> 
                      @endif
                         
                    </div> 
                   @endif  
                    
      </form> 
 
@stop