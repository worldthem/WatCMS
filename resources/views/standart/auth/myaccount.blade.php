 @if(!empty($user)) 
  <div class="col-md-6">
         <form action="{{url('/signup/updatemyaccount')}}" method="POST" > 
           <div class="shopper-info">
                 <label> {{ _l("Name") }} *</label>
                 <input type="text" name="name" value="{{ $user->name }}"  placeholder="{{ _l("Name") }} *" required="">
                  <label>{{ _l("Email") }} </label>
                  <input type="text" name="email" value="{{ $user->email }}" readonly="" >
                    <label class="chckbox_show"> 
                          <input type="checkbox" name="creataccount"  value="yes" onclick="hide_show_is(this,  '.create_account_input');"> 
                            {{ _l("Change password") }}
                    </label>
                        <div class="create_account_input" style="display: none;">
                            <label>{{ _l("Enter a new password") }} *</label>
                            <input type="password" name="password" autocomplete="off" placeholder="{{ _l("Enter a new password") }}" >
                      </div>
                  <div class="clear_10px"></div>
                  <button value="submit" type="submit" class="btn btn-default">{{ _l("Update") }}</button>
            </div>
                <div  class="clear"></div>
                <div class="showresulthere"></div>
         </form>      
  </div>
 @else
  <div class="loginBlockInPage">
   @include("standart.auth.tabslSignedForm")
   </div>
 @endif 