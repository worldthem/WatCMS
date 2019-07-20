@extends('theme::default')

@section('title', _l('My account'))
@section('content')
    <div class="containerDefault">
       <div class="col-md-12"><h2>{{_l("My account")}}</h2></div>
      @include("standart.auth.myaccount") 
      <div class="clear"></div>
   </div>       
 
@stop