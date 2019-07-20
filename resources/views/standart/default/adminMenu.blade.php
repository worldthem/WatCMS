@if(\Wh::currentRole("admin"))
<style type="text/css">
<!--
	body{
	   padding-top: 20px;
	}
-->
</style>
<div class="adminMenu">
      <div class="btn_small adminMenuIcon" onclick="menu_show_is(this,'.admin_menu')">
         {{_l("Admin Menu")}}
      </div>
      
    <ul class="nav navbar-nav navbar-right admin_menu"> 
      @foreach(\Wh::doAdminMenu() as  $k_menu=>$v_menu)
          @if(count($v_menu)>1)
              <li class="dropdown">
               <a href="#"  class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                      {{ array_shift($v_menu) }}
                     <span class="caret"></span>
                </a>
                    <ul class="dropdown-menu">
                         {!! \Wh::generateAdminMenu($v_menu) !!}
                    </ul>
              </li>
              @else
              {!! \Wh::generateAdminMenu($v_menu) !!}
              @endif
       @endforeach
    </ul>
      
</div>
@endif