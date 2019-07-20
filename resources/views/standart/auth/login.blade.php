@extends('standart.defoult')
@section('title', 'LOGIN')
@section('content')
 
        <div class="col-md-12">
               <div class="logo text-center">
                  <a href="/">
                     <img src="{{URL::to('/')}}/resources/admin_assets/img/WATCMS.png"/>
                  </a>
              </div>
            <div class="panel panel-default login" >
                  @include("standart.default.login_registre_reset")
             </div>
        </div>
     
@endsection
