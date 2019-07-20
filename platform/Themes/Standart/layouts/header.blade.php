<!-- if(\Config::get('constant.user_role')=="admin")   endif -->
<header id="header"><!--header-->
<div class="header_top" style="display: none;"> <!--header_top-->
 <div class="container-fluid">
    <div class="row">
        <div class="col-sm-4">
            @include('standart.default.currency-switch-button')
        </div>
        <div class="clear show500px"></div>
           <div class="col-sm-8 mobile_new_line">
              <div class="shop-menu pull-right">
                <ul class="nav navbar-nav">
                   @if (Auth::check())
                     {!! \Wh::get_menu("topMenuLogin") !!}
                   @else
                     {!! \Wh::get_menu("topMenuNOTLogin") !!}
                    @endif
                 </ul> 
               </div>
           </div>
    </div>
 </div>
</div><!--/header_top-->

</header><!--/header-->

<div class="header_mobile">
  
      <div class="logo_mobile">
        {!! \Wh::_logo() !!}
      </div> 
    <div class="container_menu_icon" onclick="menu_show_is($$('.container_menu_icon'),'.left-sidebar')">
      <div class="bar1"></div>
      <div class="bar2"></div>
      <div class="bar3"></div>
    </div>
    <div class="clearfix"></div>
</div>

<div class="left-sidebar clearfix" >
                 		 
    <a href="#" class="close_modalinner show_on_mobile" onclick="menu_show_is($$('.container_menu_icon'),'.left-sidebar')">x</a>
   <div class="logo logo-desktop">
      {!! \Wh::_logo() !!}
   </div>
     {!! @\Wh::shortCode('[search title=search]') !!}
      <div class="clear_10px"></div>
    
     <div class="position-relative">
       <ul class="topMenu">
        {!! \Wh::get_menu("main") !!}
       </ul>
     </div>
 </div>
