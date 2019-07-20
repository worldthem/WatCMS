<?php $shopSidebar = @strip_tags( @\Wh::shortCode(_SHOP_SIDEBAR_), '<label><h2><li><a><ul><div><input>');?>

<ul class="shop-filter-menu">
   @if(!empty($shopSidebar)) 
     <li> 
       <a href="#filter" class="filtersButtonHeader">
          {{_l('Filters')}}
       </a>
     </li>
    @endif 
     <li>
      <span>/</span> 
        {{_l('Price')}} :  
        <a href="{{url('/pr/sort/asc')}}"><i class="fa fa-sort-amount-asc"></i> </a> 
        <a href="{{url('/pr/sort/desc')}}"><i class="fa fa-sort-amount-desc"></i></a>
     </li>
</ul>

<div class="clear_20px"></div>

<div class="searchFormHeader">
{!!\Wh::shortCode("[search]")!!}
</div>

<div class="filtersHeader">
{!! \Wh::quickEdit('/admin/editable-blocks/shop-sidebar', 'editPageLinkFixed') !!}
 
 {!! @$shopSidebar !!}
</div>