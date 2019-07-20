@extends('standart.defoult')
@section('title', 'Instalation')
@section('content')
 
        <div class="col-md-12">
        
            <div class="panel panel-default login">


  <div class="panel-body">
          {!! @$error !!}
      <form class="form-horizontal" method="POST" action="{{ url('/install/final') }}">
          {{ csrf_field() }}
       <h2 class="text-align-center">{{ _l("Create Admin User") }}</h2>
       
       
       
       <div class="form-group">
         <div class="col-md-12">
            <input  type="text" name="websitename" value="{{ @$websitename }}" placeholder="{{_l('Website name')}}"  class="form-control" required>
         </div>
      </div>
      <div class="form-group">
         <div class="col-md-12">
            <input  type="text" name="name" value="{{ @$name }}" placeholder="{{_l('Admin name')}}"  class="form-control" required>
         </div>
      </div>
       <div class="form-group">
         <div class="col-md-12">
            <input  type="email" name="adminuser" value="{{ @$adminuser }}" placeholder="{{_l('Admin Email (Email is a user name)')}}"  class="form-control"  required>
         </div>
       </div>
      
       <div class="form-group">
         <div class="col-md-12">
            <input  type="text" name="adminpassword" value="{{ @$adminpassword }}" placeholder="{{_l('Admin Password')}}"  class="form-control" required>
         </div>
       </div>
       

      <div class="form-group">
           <div class="col-md-12 text-align-center">
                <button type="submit" class="login100-form-btn">
                    {{ _l("Install") }}
                </button> 
          </div>
      </div>
  </form>
</div>

 </div>
 </div>
     
@endsection