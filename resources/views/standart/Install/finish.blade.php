@extends('standart.defoult')
@section('title', 'Instalation')
@section('content')
<div class="col-md-12">
  <div class="panel panel-default login">
     <div class="panel-body"> 
       <div class="install">
             <div class="text-center">
                <p>{!! @$message !!}</p>
                <a href="{{url('/')}}" class="login100-form-btn">{{ _l('Access Home') }}</a>
                <a href="{{url('/admin')}}" class="login100-form-btn">{{ _l('Access Dashboard')}}</a>
             </div>
       </div>
     </div>
  </div>
</div>
     
@endsection