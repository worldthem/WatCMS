@extends('admin.layouts.default')

@section('title', 'Edit Users')
@section('content')
 
<div class="col-md-12">
 <div class="card">
      
     <div class="header">
          <h4 class="title">{{ _l('Users') }}</h4>
     </div>
     <div class="col-md-7 full_label">  
       <form action="{{URL::to('/')}}/admin/users/store" method="post">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input type="hidden" name="id" value="{{$val->id}}">
          
          <label>
              {{_l("Registred date")}}:{{$val->created_at }} <br />
          </label>
          
          <label>
              {{_l("User Name")}} <br />
              <input type="text" name="name" class="form-control" value="{{$val->name}}">
          </label>
          
          <label>
              {{_l("User Email")}} <br />
              <input type="text" name="email" class="form-control" value="{{$val->email}}">
          </label>
          
          <label>
              {{_l("Phone")}} <br />
              <input type="text" name="meta[phone]" class="form-control" value="{{@$meta['phone']}}">
          </label>
          
          <label>
             {{_l("Role")}}{{$val->id === 1 ? ": Admin":""}}  <br />
             @if($val->id === 1)
              <input type="hidden" name="user_role" class="form-control" value="{{$val->user_role}}">
              @else
             <select class="form-control" name="user_role">
                  <option selected=""> Select </option>
                @foreach ($roles as $role){
                  <option value="{{$role->id}}" {{$val->user_role == $role->id ? ' selected=""': ''}}>{{$role->role_name}}</option>
                @endforeach
             </select>
             @endif
          </label>
             
           <label>
              {{_l("User Password")}}  <br />
              <input type="text" name="password" class="form-control" placeholder="*****" value="">
              <small> <i> {{_l("Leave empty if you don't want to change")}} </i></small>
          </label>
          
           <label>
              <input type="submit" class="btn btn_small"  value="{{_l('Update')}}">
          </label>
           
           <div class="clear"></div>
      </form>  
   </div>
   <div class="clear"></div>
  </div>
 </div> 
@stop      