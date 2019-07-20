@extends('admin.layouts.default')

@section('title', 'Users')
@section('content')
 
<div class="col-md-12">
 <div class="card">
      
     <div class="header">
          <h4 class="title">{{ _l('Users') }}</h4>
     </div>
     <div class="add_new_top">  
    <form action="{{URL::to('/')}}/admin/users/store" method="post">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input type="hidden" name="id" value="new">
          <div class="col-md-2">
             <label> {{ _l('Usr Role') }} <br />
                  <select name="user_role" class="form-control" >
                    @foreach ($roles as $role){
                      <option value="{{$role->id}}">{{$role->role_name}}</option>
                    @endforeach
                 </select>
             </label>
          </div>
           <div class="col-md-2">
             <label> {{ _l('User name') }} <br />
                <input type="text" name="name" required="" class="form-control"/>
             </label>
          </div>
          
          
          
          <div class="col-md-2">
             <label> {{ _l('Email') }}<br />
                <input type="email" name="email" required="" class="form-control"/>
                
             </label>
          </div>
          
           <div class="col-md-2">
             <label> {{ _l('Password') }}<br />
                <input type="text" name="password" required="" class="form-control" placeholder="******"/>
             </label>
           </div>
          
         <div class="col-md-1"><br />
           <button type="submit" class="btn btn_small">{{ _l('Add new one') }} </button>  
        </div>
         
     <div class="clear"></div>
    </form> 
   </div> 
     
     <form action="{{URL::to('/')}}/admin/users/destroy-bulk" method="post">
         <input type="hidden" name="_token" value="{{ csrf_token() }}">
           <div class="col-md-2">
               <select name="action" class="form-control" >
                <option value="">{{ _l('Action') }}</option>
                <option value="del">{{ _l('Remove') }} </option>
               </select>
          </div>
         
        <div class="col-md-1">
           <button type="submit" class="btn btn_small">{{ _l('Apply') }}</button>  
        </div>
           <div class="col-md-6"><br /></div>
          
          <div class="col-md-2">
           <input type="text" class="form-control" name="s" value=""  placeholder="{{ _l('Search') }}"/>
         </div>
          <div class="col-md-1">
            <button type="submit" class="btn btn_small">{{ _l('Search') }}</button>  
          </div>
         
     <div class="clear"></div>
     
     <div class="content table-responsive table-full-width">
         <table class="table table-hover table-striped">
             <thead>
                 <th><input type="checkbox" id="checkall" onclick="check_all(this);" /></th>
                 <th>ID</th>
                 <th>{{ _l('User name') }}</th>
                 <th>{{ _l('Email') }}</th>
                  <th>{{ _l('Role') }}</th>
                 <th>{{ _l('Date') }}</th>
                 <th>{{ _l('Orders') }}</th>
                 <th style="width: 40px"> </th>
                 <th style="width: 40px"> </th>
                 <th style="width: 40px"> </th>
             </thead>
             <tbody>
                @foreach ($rows as $val)

                 <tr id="edit_this_nr{{$val->id}}"> 
                       <td> <input type="checkbox" name="rowid[]" class="checkboxeach"  value="{{$val->id}}"></td>
                       <td>{{$val->id}}</td>
                       <td> <a href="{{url('/admin/users/single/'.$val->id)}}">{{$val->name}}</a></td>
                       <td> <a href="{{url('/admin/users/single/'.$val->id)}}">{{$val->email}}</a></td>  
                        
                       
                      <td> {{@\Wh::get_role($val->user_role)}} </td>
                        
                      <td> {{$val->created_at}}</td>  
                      <td> 
                         <a href="{{URL::to('/')}}/admin/view-user-orders/{{$val->id}}">View orders</a>
                      </td>
                      <td> 
                         <a href="{{url('/admin/users/single/'.$val->id)}}" class="fa_edit"> </a>
                     </td>
                      <td> 
                       @if($val->id != "1")
                         <a href="{{URL::to('/')}}/admin/users/destroy/{{$val->id}}" class="fa_delete" onclick="return confirm('You are sure?') ? true : false;"> </a>
                        @endif
                     </td>
                     <td class="result{{$val->id}}"></td>
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