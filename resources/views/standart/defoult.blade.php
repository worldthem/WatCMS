<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
      <link href="{{URL::to('/')}}/resources/assets/css/bootstrap.min.css" rel="stylesheet"/>
      <link href="{{URL::to('/')}}/resources/assets/css/login.css" rel="stylesheet"/>
     </head><!--/head-->
<body >
    
         
           <div class="container-fluid">
             <div class="row" id="livesearch">
               @yield('content')
             </div>
           </div>
       
    <script type="text/javascript">
    <!--
    	var url_theme = '{{_THEME_PATH_}}';
        var url_assets = '{{URL::to('/')."/resources/assets/"}}';
        var WajaxURL = '{{URL::to('/')."/wajax.jsp"}}';
    -->
    </script>
    <script src="{{URL::to('/')}}/resources/assets/js/js-helper.js"></script>
    <script src="{{URL::to('/')}}/resources/assets/js/jsonly.js"></script>
</body>
</html>