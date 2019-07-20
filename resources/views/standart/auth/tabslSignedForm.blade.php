<?php 
   $rand1= rand();
   $rand2= rand();
   $rand3= rand();
 ?>
 <ul>
   <li class="resp-tab-item tab_buttons tab1-1 active"  onclick="return setTab('tab1-1');" ><span>{{_l("Sign in")}}</span></li>
   <li class="resp-tab-item tab_buttons tab2-2"  onclick="return setTab('tab2-2');" ><span>{{_l("Create an Account")}}</span></li>
</ul>
<div class="tab-1 resp-tab-content tab-pane" id="tab1-1" aria-labelledby="tab_item-0">
   <div class="facts">
      <div class="register">
         <form id="login_form{{$rand1}}" onsubmit="wajax('.show_result{{$rand1}}', '', '#login_form{{$rand1}}' ); return false;">
                <input type="hidden" name="action" value="authenticate" />
                <input type="hidden" name="method" value="ajax" />
                
               <input name="email" placeholder="{{_l("Email Address")}}" type="email" required="" value=""> 
               <input name="password" placeholder="{{_l("Password")}}" type="password" required="" value="">
               <div class="sign-up"> 
                <input type="submit" value="{{_l("Sign in")}}"  />  
                <a href="#" class="tab3-3 tab_buttons reset_pass_btn" onclick="return setTab('tab3-3');" ><span> {{_l("Forgot Your Password?")}}</span></a>
              </div>
            <p> <span class="show_result{{$rand1}}"></span></p>
         </form>
         
      </div>
   </div>
</div>
<div class="tab-2 resp-tab-content tab-pane display_none" id="tab2-2" aria-labelledby="tab_item-1">
   <div class="facts">
      <div class="register">
        <div class="clear_10px"></div>
         <form id="registration_form{{$rand2}}" onsubmit="wajax('.show_result{{$rand2}}', '', '#registration_form{{$rand2}}' ); return false;">
                <input type="hidden" name="action" value="registration" />
                <input type="hidden" name="method" value="ajax" />
                
             <input placeholder="{{_l("Name")}}" name="name" required="" type="text"> 
             <input placeholder="{{_l("Email Address")}}" name="email" type="email" required=""> 
             <input placeholder="{{_l("Password")}}" name="password" type="password" required="">
             <div class="sign-up"> 
              <input type="submit" value="{{_l("Create an Account")}}" />
            </div>
            <p> <span class="show_result{{$rand2}}"></span></p>
         </form>
      </div>
   </div>
</div>
<div class="tab-3 resp-tab-content tab-pane display_none" id="tab3-3" aria-labelledby="tab_item-2">
   <div class="facts">
      <div class="register">
         <form id="reset_pass{{$rand3}}" onsubmit="wajax('.show_result{{$rand3}}', '', '#reset_pass{{$rand3}}' ); return false;">
                <input type="hidden" name="action" value="resetpass" />
                <input type="hidden" name="method" value="ajax" />
             
             <input name="email" placeholder="{{_l("Email Address")}}" type="email" required=""/>
             <div class="sign-up"> 
               <input type="submit" value="{{_l("Reset password")}}"/>
             </div>
             
             <p> <span class="show_result{{$rand3}}" ></span></p>
         </form>
      </div>
   </div>
</div>