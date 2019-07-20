@extends('admin.layouts.default')

@section('title',  ucfirst(@$type) )
@section('content')
 
<div class="col-md-12">
 <div class="card">
     <div class="header">
         <h4 class="title">{{  _l(ucfirst(@$type)). " ". _l("Categories") }}</h4>
           <p>
               <a class="btn" href="{{URL::to('/')}}/admin/categories/add-edit/{{$type}}/new">{{ _l('Add new one') }}</a>
           </p>
     </div>
     
     <form action="{{URL::to('/')}}/admin/categories-bulk" method="post">
         <input type="hidden" name="_token" value="{{ csrf_token() }}">
         <div class="col-md-2">
              <select  name="action" class="form-control" >
                <option value="">{{ _l('Action') }}</option>
                <option value="del">{{ _l('Delete') }} </option>
              </select>
        </div>
        <div class="col-md-1">
           <button type="submit" class="btn btn_small">{{ _l('Apply') }}</button>  
        </div>
        <div class="clearfix"></div>
     <div class="content table-responsive table-full-width">
         <table class="table table-hover table-striped">
             <thead>
                 <th style="width: 40px;"><input type="checkbox" id="checkall" onclick="check_all(this);" /></th>
                 <th>{{ _l('ID') }}</th>
                 <th>{{ _l('Title') }}</th>
                 <th>{{ _l('CPU') }}</th>
                 <th style="width: 100px;"> </th>
                 <th  style="width: 40px;"> </th>
             </thead>
             <tbody>
                  {!! \Wh::get_cat_yerahical($cat, 0, 0,$type) !!}
             </tbody>
         </table>
         
           {!! $cat->appends(Input::all())->render() !!}
     </div>
   </form>  
 </div>
</div>
@stop