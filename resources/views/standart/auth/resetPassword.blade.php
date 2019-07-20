@extends('standart.defoult')
@section('title', 'Reset Password')
@section('content')
 
        <div class="col-md-12">
               <div class="logo text-center">
                 {!! \Wh::_logo() !!}
              </div>
            <div class="panel panel-default login" >
                 <div class="register">
                 <h2>{{_l("Enter your new password")}}</h2>
                     <form id="reset_pass" onsubmit="wajax('.show_result2', '', '#reset_pass' ); return false;">
                        <input type="hidden" name="action" value="new_password_update" />
                        <input type="hidden" name="method" value="ajax" />
                        <input type="hidden" name="reset_token" value="{{@$token}}" />
                        
                         <input name="password" placeholder="{{_l("New Password")}}" type="password" required=""/>
                         <input name="password_repeat" placeholder="{{_l("Repeat Password")}}" type="password" required=""/>
                          
                          <div class="sign-up"> 
                           <input type="submit" value="{{_l("Reset password")}}"/>
                         </div>
                     
                        <p> <span class="show_result2" ></span></p>
                    </form>
                </div>  
             </div>
        </div>
     
@endsection