{!! \Wh::hooks('beginheader') !!}
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
 {!! \Wh::_favicon() !!}
<title>@yield('title')</title>
 @include("assets::css.bootstrap_min_css")
 <meta name="description" content="@yield('metad')">
 <meta name="author" content="@yield('metak')">
<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">
   <?php \Wh::showCss(); ?>
  
  @include("standart.default.header-css",['optionsData'=> ($rows->options ?? [])])
  
{!! \Wh::editableBlocks(@_HEADER_ , 'css') !!}
{!! \Wh::editableBlocks(@_FOOTER_ , 'css') !!}

{!! \Wh::hooks('header') !!}