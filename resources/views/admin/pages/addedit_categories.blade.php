@extends('admin.layouts.default')

@section('title', !empty($page)? _l('Edit').':'.$page->title :_l('Create new')." ".ucfirst(@$type) )
@section('content')
  <div class="col-md-12">
          <div class="card">
                 <div class="header">
                    <h4 class="title"> {{ !empty($page)? _l('Edit').':'.$page->title :_l('Create new')." ".ucfirst(@$type) }} </h4>

                </div>

                <div class="content">
                    <form action="{{URL::to('/')}}/admin/update-categories" method="POST" >
                     <input type="hidden" name="_token" value="{{ csrf_token() }}">
                     <input type="hidden" name="id" value="{{@$page->id}}">
                     <input type="hidden" name="type" value="{{@$type}}">
                     <div  class="col-md-6">
                         <p>
                            <label>{{ _l('Title') }} </label> <br/>
                            <input type="text" class="form-control" name="title" value="{{@$page->title}}">
                         </p>
                      </div>
                     <div  class="col-md-6">
                         <p>
                            <label>{{ _l('Parent') }}</label> <br/>
                             <select name="parent" class="form-control" >
                                 <option> {{ _l('Select parent') }}</option>
                                 {!! \Wh::get_cat_yerahical_option(\Wh::getAllCategories_all(@$type), 0, 0, '',@$page->parent)  !!}
                            </select>
                        </p>
                      </div> 
                     <div class="clear"></div>
                       
                    <div  class="col-md-6">
                        <p>
                            <label>{{ _l('CPU') }} </label> <br/>
                            <input type="text" class="form-control" name="cpu" value="{{@$page->cpu}}">
                        </p>
                     </div>
                     
                     <div  class="col-md-6">
                        <p>
                            <label>{{ _l('External URL') }} </label> <br/>
                            <input type="text" class="form-control" name="url" value="{{@$page->url}}">
                        </p>
                     </div>
                     
                    <div  class="col-md-6">
                         <p>
                            <label>{{ _l('Meta description') }} </label> <br/>
                            <input type="text" class="form-control" name="metad" value="{{@$page->metad }}">
                         </p>
                     </div>
                    <div  class="col-md-6">

                          <p> <label>{{ _l('Meta keyword') }} </label> <br/>
                            <input type="text" class="form-control" name="metak" value="{{@$page->metak }}">
                          </p>
                     </div>
                     <div  class="col-md-6" style="display: none;">
                          <p> <label>{{ _l('Template') }} </label> <br/>
                            <input type="text" class="form-control" name="template" value="{{@$page->template}}">
                          </p>
                     </div>
                    <div class="height20px"></div>
                    <div class="col-md-12">
                        <textarea name="text" id="editor" class="form-control tinymce">{{@$page->text}}</textarea>
                    </div>
                    <div class="height10px"></div>
                    <div class="text-center">
                        <input type="submit" class="btn" value="{{ _l('Save') }}">
                    </div>
                    </form> 
                </div>
            </div>
 </div>
      
<script>
	initSample();
</script>
@stop