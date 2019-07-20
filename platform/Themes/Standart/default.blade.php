<!DOCTYPE html>
<html lang="en">
<head>
   @include('standart.default.head')
   <link href="{{_THEME_PATH_}}/css/style.css" rel="stylesheet"/> 
</head><!--/head-->
    
<body id="body_scroll">
  <div class="main">
      @include('theme::layouts.header')
        <section class="content-part clearfix" >
                 <ul class="head_menu">
                   @if (Auth::check())
                     {!! \Wh::get_menu("topMenuLogin") !!}
                   @else
                     {!! \Wh::get_menu("topMenuNOTLogin") !!}
                    @endif
                 </ul>
                 <div class="clearfix"></div>
           <div id="livesearch"> 
             @yield('content')
          </div>
       </section>
    </div>
   
      <div class="clearfix"></div>
    {!! \Wh::editableBlocks(@_FOOTER_) !!}
       
    @include('theme::layouts.footer') 
   
@include('standart.default.footer')
<script src="{{_THEME_PATH_}}/js/main.js"></script>
 
</body>
</html>