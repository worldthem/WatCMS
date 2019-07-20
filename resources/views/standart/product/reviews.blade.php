<?php $commnets = \Wh::get_comments($product->id); ?>
 
<div class="col-md-6">
 @if(count($commnets)>0)
 <?php $array_commnts = nr_comments($commnets); ?>
   <div class="review-overall">
        <div class="main-review">{{\Wh::comments_Overall(@$commnets)}}</div>
        <span>({{count($commnets)}} {{ _l('Reviews') }})</span>
    </div>
        
         <div class="review-count">
          <?php for($i=5; $i>=1; $i--){?>
            <div class="single-review-count d-flex align-items-center">
                 
                <span class="stars{{$i}}"></span>
                <span>({{ isset($array_commnts[$i])? $array_commnts[$i] : 0 }})</span>
            </div>
            <?php } ?>
             
        </div>



@foreach($commnets as $commnet) 
    <div class="clear_15px"></div>
	<ul class="comment_header">
		<li><a href="#"> <b>{{$commnet->comment_author}}</b> </a></li>
        <li><a href="#"><span class="theme_calendar"></span> {{date("F d, Y", strtotime($commnet->created_at))}}</a></li>
        <li> <span class="stars{{$commnet->stars}}"></span> </li>
         
	</ul>
     <p> {{$commnet->comment}} </p>
@endforeach	 

@else
<h3>No reviews yet</h3>
@endif 
</div>

<div class="col-md-6">
 <form  class="shopper-info" id="submit_comment" method="POST" onsubmit="wajax('.resul_checkou', 'reset', '#submit_comment' ); return false;"  >
	    <input type="hidden" name="id_post" value="{{$product->id}}" />
        <input type="hidden" name="id_user" value="{{@\Wh::id_user()}}"    />
        <input type="hidden" name="stars" value="5"  id="stars_input" />
         <input type="hidden" name="action" value="new_comment" />
		<input type="text" name="comment_author" required=""  placeholder="{{ _l('Your Name') }}" />
		<input type="email" name="comment_author_email" required=""  placeholder="{{ _l('Email Address') }}" />
	    <textarea name="comment" required="" ></textarea>
        
        
	 	  <span class="stars5" id="stars_click">
           <span onclick="stars_point('stars_click','stars_input', '1');"></span>
           <span onclick="stars_point('stars_click','stars_input', '2');"></span>
           <span onclick="stars_point('stars_click','stars_input', '3');"></span>
           <span onclick="stars_point('stars_click','stars_input', '4');"></span>
           <span onclick="stars_point('stars_click','stars_input', '5');"></span>
          </span>  
          
        <button type="submit" class="btn btn-default pull-right">
			{{ _l('Submit') }}
		</button>
        <div class="clear"></div>
       <div class="resul_checkou"></div> 
	</form>
</div>

               