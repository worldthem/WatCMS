 <div class="subscribe_box">
     <form action="#" id="subscribeToNews" method="POST" onsubmit=" wajax('.resultSubscribe', 'reset', '#subscribeToNews'); return false; "> 
       <input type="hidden" name="action" value="subscribe"  />
       <input type="text" name="email" value="" placeholder="{{ _l('Email') }}" required=""/>
       <button type="submit"> <i class="fa fa-long-arrow-right"></i> </button>
       <div class="clear"></div>
       <div class="resultSubscribe"></div>
     </form>   
 </div>