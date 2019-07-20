<script type="text/javascript">
       var url_theme = '{{_THEME_PATH_}}';
        var url_assets = '{{URL::to('/')."/resources/assets/"}}';
        var WajaxURL = '{{URL::to('/')."/wajax.jsp"}}';
</script>

@include('standart.default.login_registre_reset')
@include('standart.default.popup')
 <div class="small_cart"  >
   <div class="inner_smallcart">
        <a href="{{URL::to('/')}}/steps/cart" class="btn btn-default update cart_small_btn_top"> {{ _l('Cart')}} </a>
        <a href="{{URL::to('/')}}/steps/checkout" class="btn btn-default update cart_small_btn_top"> {{ _l('Checkout')}} </a>
        <a href="#" onclick="return hide_elem('.small_cart'); " class="btn btn-default update cart_small_btn" > 
            <i class="fa fa-times"></i> 
        </a>
        <div class="clearfix"></div>
        <div class="load_content_smallcart"> </div>   
   </div>   
</div>
<span class="pointdb"></span>

<script src="{{URL::to('/')}}/resources/assets/js/js-helper.js"></script>
<script src="{{URL::to('/')}}/resources/assets/js/jsonly.js"></script>
 <script src="{{URL::to('/')}}/resources/assets/js/lazyload.min.js"></script>
<link href="{{URL::to('/')}}/resources/assets/css/font-awesome.min.css" rel="stylesheet"/>
<?php

    
?>
 <script type="text/javascript">  
  new LazyLoad();
   
   window.addEventListener('load', function(){
     calUrl('{!! \Wh::AnaliticsURL() !!}', '',  'noresult');
   
   }, false);
 
</script>
 
<div class="quickEditWindow"></div>

{!! \Wh::hooks('footer') !!}
{!! _FOOTERJS_ !!}
@include('standart.default.adminMenu')