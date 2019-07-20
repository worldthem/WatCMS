@extends('theme::default')

@section('title', '404')
@section('content')

<div class="container text-center">
     
    <div class="content-404">
            
    <h1><b> {{_l("OPPS")}}!</b>  {{ empty($errorType) || @$errorType =='404'?  _l("We Couldn’t Find this Page"): _l("Something went wrong, couldn't run the script")}}</h1>
     
     
   <div class="clear_40px"></div>        
   <h2><a href="{{URL::to('/')}}">{{_l("Bring me back Home")}}</a></h2>
            
             
    </div>
</div>
@stop
