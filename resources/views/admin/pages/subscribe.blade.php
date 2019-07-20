@extends('admin.layouts.default')

@section('title', 'Subscribers')
@section('content')
 
<div class="col-md-12">
 <div class="card">
      
     <div class="header">
          <h4 class="title">{{ _l('Subscribers') }}</h4>
     </div>
    
     
     <form action="{{URL::to('/')}}/admin/subscribe/destroy-bulk" method="post">
         <input type="hidden" name="_token" value="{{ csrf_token() }}">
           <div class="col-md-2">
               <select name="action" class="form-control" >
                <option value="">{{ _l('Action') }}</option>
                <option value="del">{{ _l('Remove') }} </option>
               </select>
          </div>
         
        <div class="col-md-2">
           <button type="submit" class="btn btn_small">{{ _l('Apply') }}</button>  
        </div>
           <div class="col-md-2"><br /></div>
          
          <div class="col-md-2">
           <input type="text" class="form-control" name="s" value="{{@$getvar}}"  placeholder="{{ _l('Search') }}"/>
         </div>
          <div class="col-md-2">
            <button type="submit" class="btn btn_small">{{ _l('Search') }}</button>  
          </div>
          <div class="col-md-2 text-right">
             <a href="{{url('/admin/subscribe/export/'.(!empty($getvar)? @$getvar : 'all') )}}" class="btn btn_small">{{_l("Export")}}</a>
          </div>
         
     <div class="clear"></div>
     
     <div class="content table-responsive table-full-width">
         <table class="table table-hover table-striped">
             <thead>
                 <th><input type="checkbox" id="checkall" onclick="check_all(this);" /></th>
                 <th>{{ _l('Email') }}</th>
                 <th>{{ _l('Date') }}</th>
              </thead>
             <tbody>
                @foreach ($rows as $val)

                 <tr> 
                       <td> <input type="checkbox" name="rowid[]" class="checkboxeach"  value="{{$val->id}}"></td>
                       <td> {{$val->email}} </td>
                       <td> {{$val->date}}</td>  
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