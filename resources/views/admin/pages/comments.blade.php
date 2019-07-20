@extends('admin.layouts.default')

@section('title', 'Reviews')
@section('content')
 
<div class="col-md-12">
 <div class="card">
     <div class="header">
          <h4 class="title">{{ _l('Comments/Reviews') }}</h4>
     </div>
     
     <form action="{{URL::to('/')}}/admin/comments/destroy-bulk" method="post">
         <input type="hidden" name="_token" value="{{ csrf_token() }}">
           <div class="col-md-2">
             <select name="action" class="form-control" >
                <option value="">{{ _l('Action') }}</option>
                <option value="del"> {{ _l('Remove') }} </option>
                <option value="aprove"> {{ _l('Aprove') }} </option>
                <option value="inaprove"> {{ _l('Inaprove') }} </option>
            </select>
          </div>
         
        <div class="col-md-1">
           <button type="submit" class="btn btn_small">{{ _l('Apply') }}</button>  
        </div>
          <div class="col-md-1">
           <br />
        </div>  
     <div class="col-md-3" class="text_align_right">
       <select class="form-control"  onchange="if (this.value) window.location.href=this.value">
            <option value="{{URL::to('/')}}/admin/comments/status/all"> All</option>
            <option value="{{URL::to('/')}}/admin/comments/status/1" {{@$getvar=="1"? ' selected=""':''}} >New Comments/Reviews </option>
            <option value="{{URL::to('/')}}/admin/comments/status/2" {{@$getvar=="2"? ' selected=""':''}} >Aproved Comments/Reviews </option>
       </select>
     </div>
     <div class="col-md-1">
           <br />
        </div>
          <div class="col-md-2">
           <input type="text" class="form-control" name="s" value=""  placeholder="{{ _l('Search') }}"/>
         </div>
          <div class="col-md-2">
            <button type="submit" class="btn btn_small">{{ _l('Search') }}</button>  
          </div>
         
     <div class="clear"></div>
     
     <div class="content table-responsive table-full-width">
         <table class="table table-hover table-striped">
             <thead>
                 <th><input type="checkbox" id="checkall" onclick="check_all(this);" /></th>
                 <th>{{ _l('Status') }}</th>
                
                 <th>{{ _l('Author') }}</th>
                 <th>{{ _l('Comment') }}</th>
                 
                 <th>{{ _l('Product') }}</th>
                 <th>{{ _l('Date') }}</th>
                 <th style="width: 40px"> </th>
                 
             </thead>
             <tbody>
                @foreach ($rows as $val)

                 <tr> 
                     <td> <input type="checkbox" name="productid[]" class="checkboxeach"  value="{{$val->id}}"></td>
                     <td> <a href="{{URL::to('/')}}/admin/comments/comment-status/{{$val->id}}/{{$val->status==2? 1:2}}" title="Change status" class="{{$val->status==2 ? 'fa_publish':'fa_unpublish'}}" ></td>
                   
                      <td>
                         
                           @if($val->id_user > 0)
                              <a href="{{URL::to('/')}}/admin/users/search/{{$val->id_user}}"><b>{{$val->comment_author}}</b></a>
                            @else
                               <b> {{$val->comment_author}}</b>
                            @endif
                            <br />
                           <b>{{$val->comment_author_email}}</b> <br />
                           <span class="stars{{$val->stars}}"></span>
                            {{$val->comment_author_IP}}
                      </td>
                     <td style="max-width: 600px;"> {!! $val->comment !!} </td>
                     <td> 
                      <a href="{{get_product_cpu($val->id_post, "yes")}}">
                        {{ \Wh::get_product_field($val->id_post,'title')}}
                      </a>
                     </td>
                     <td> {{$val->created_at}}</td>  
                      <td> 
                         <a href="{{URL::to('/')}}/admin/comments/destroy/{{$val->id}}" class="fa_delete" onclick="return confirm('You are sure?') ? true : false;"> </a>
                     </td>
                     
                 </tr>
                @endforeach
             </tbody>
         </table>
 
     </div>
     {!! $rows->appends(Input::all())->render() !!}
     </form>  
 </div>
</div>
@stop