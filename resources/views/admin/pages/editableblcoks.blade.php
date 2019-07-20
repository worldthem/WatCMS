@extends('admin.layouts.default')

@section('title', @lcfirst(trim (str_replace(['_','-']," ",$type))))
@section('content')
   <form action="{{URL::to('/')}}/admin/editable-blocks/save" method="POST"  class="updateFormPage">
     <input type="hidden" name="_token" value="{{ csrf_token() }}">
     <input type="hidden" name="param" value="{{@$type}}">
     <input type="hidden" name="editor" value="{{$editor ?? 'builder'}}">
    <div class="height30px"></div> 
     <div class="col-md-12">
         <div class="card">
          @if($editor =='editor')
          <div class="height10px"></div>
          <div class="col-md-12">
           <textarea name="text" id="editor" class="form-control tinymce">{{@$page}}</textarea>
            <div class="height10px"></div>
              <div class="text-center">
                <input type="submit" class="btn save_content btn_active" value="{{ _l('Save') }}"/>
             </div>
            <div class="height10px"></div>
          </div>  
          <div class="height10px"></div>
          @else
            @include('admin.layouts.page-editor', ['content' => @$page ])
          @endif  
         </div> 
    </div> 
  </form> 
@stop 