@extends('admin.layouts.default')

@section('title', @$type)
@section('content')
 
<div class="col-md-12">
 <div class="card">
     <div class="header">
       <h4 class="title"> {{ _l('List of') }} {{_l(@$type)}}</h4>
       @if(!in_array('editonly',($post_type[$type] ?? [])))
         <p>
          <a class="btn" href="{{URL::to('/')}}/admin/page/add-edit/{{@$type}}/new"> {{ _l('Add new one') }}</a>
        </p>
       @endif  
     </div>
     
     <form action="{{URL::to('/')}}/admin/page/destroy-bulk/{{@$type}}" method="post">
         <input type="hidden" name="_token" value="{{ csrf_token() }}">
         @if(!in_array('editonly',($post_type[$type] ?? [])))
           <div class="col-md-2">
               <select name="action" class="form-control" >
                <option value="">{{ _l('Action') }}</option>
                <option value="del">{{ _l('Remove') }} </option>
               </select>
          </div>
         
           <div class="col-md-1">
              <button type="submit" class="btn btn_small">{{ _l('Apply') }}</button>  
           </div>
        
           <div class="col-md-6">
           @if(count($categories) > 0)
              <select class="form-control"  onchange="if (this.value) window.location.href=this.value">
                <option value="{{url('/admin/page/'.$type)}}" >{{ _l('Show from category') }}</option>
                  {!! \Wh::get_cat_yerahical_option($categories, 0, 0, "/admin/page/show-from-cat/".$type , (!empty($catid)? $catid: 0))  !!}
              </select>
           @else
            <br />
           @endif
           </div>
          
          <div class="col-md-2">
           <input type="text" class="form-control" name="s" value=""  placeholder="{{ _l('Search') }}"/>
         </div>
          <div class="col-md-1">
            <button type="submit" class="btn btn_small">{{ _l('Search') }}</button>  
          </div>
         @endif
     <div class="clear"></div>
     
     <div class="content table-responsive table-full-width">
         <table class="table table-hover table-striped">
             <thead>
                 <th style="width: 30px;"><input type="checkbox" id="checkall" onclick="check_all(this);" /></th>
                 <th style="width: 30px;">ID</th>
                 @if(in_array('enable',@$post_type[$type])) <th style="width: 79px;"> {{ _l('Enabled') }}</th> @endif
                 <th> {{ _l('Title') }}</th>
                 @if(in_array('cpu',@$post_type[$type])) <th> {{ _l('CPU') }}</th> @endif
                @if($type=='emails') <th> {{ _l('Page type') }}</th>@endif
                 <th style="width: 40px;"></th>
                 <th style="width: 40px;"></th>
             </thead>
             <tbody>
                @foreach ($page as $val)
                  <?php $json = @json_decode(@$val->options, true);?>
                 <tr>
                      <td> <input type="checkbox" name="rowid[]" class="checkboxeach"  value="{{$val->id}}"></td>
                      <td>{{$val->id}}</td>
                         @if(in_array('enable',@$post_type[$type])) 
                            <td> 
                              <input type="checkbox" {{!empty($json['enable'])? 'checked=""':''}} onclick="window.location.href = '{{url('/admin/page-enable/'.$val->id)}}'" /> 
                            </td> 
                         @endif
                      <td>{{$val->title}} </td>
                     
                      @if(in_array('cpu',@$post_type[$type])) <td>{{$val->cpu}} </td> @endif
                      @if($type=='emails')<td> {{$val->main}}</td>@endif
                       <td> 
                         <a href="{{URL::to('/')}}/admin/page/add-edit/{{@$type}}/{{$val->id}}" title="Edit" class="fa_edit"> </a>
                      </td>
                       <td> 
                          @if(!in_array('editonly',($post_type[$type] ?? [])))
                             <a href="{{URL::to('/')}}/admin/page/del/{{$val->id}}" class="fa_delete" onclick="return confirm('You are sure?') ? true : false;"></a>
                          @endif
                      </td>
                 </tr>
                @endforeach
             </tbody>
         </table>
          {!! $page->appends(Input::all())->render() !!}
        </form>  
     </div>
 </div>
</div>
@stop