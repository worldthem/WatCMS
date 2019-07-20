 
@extends('standart.defoult')
@section('title', 'Instalation')
@section('content')
 
        <div class="col-md-12">
            <div class="panel panel-default login">

<div class="install">
    <?php
    $check = true;

    function alert_message($message = '', $type = '')
    {
        return '<div class="alert alert-' . $type . '" role="alert">' . $message . '</div>';
    }
   /*  
    // config is writable
    if (is_writable(CONFIG)) {
        //echo alert_message( _l( 'Your config directory is writable.' ), 'success' );
    } else {
        $check = false;
        echo alert_message(_l('Your config directory is NOT writable.'), 'danger');
    }
    */
    // php version
    $minPhpVersion = '7.1.3';
    $operator = '>=';
    echo PHP_VERSION;
    if (version_compare(PHP_VERSION, $minPhpVersion, $operator)) {
        //echo alert_message( _l( 'PHP version {0} {1} {2}', PHP_VERSION, $operator, $minPhpVersion ), 'success' );
    } else {
        $check = false;
        echo alert_message(_l('PHP version {0} < {1}', PHP_VERSION, $minPhpVersion), 'danger');
    }

    if (extension_loaded('mbstring')) {
        //echo alert_message( _l( 'Your version of PHP has the mbstring extension loaded.' ), 'success' );
    } else {
        $check = false;
        echo alert_message(_l('Your version of PHP does NOT have the mbstring extension loaded.'), 'danger');
    }

    if (extension_loaded('openssl')) {
        //echo alert_message( _l( 'Your version of PHP has the openssl extension loaded.' ), 'success' );
    } elseif (extension_loaded('mcrypt')) {
        //echo alert_message( _l( 'Your version of PHP has the mcrypt extension loaded.' ), 'success' );
    } else {
        $check = false;
        echo alert_message(_l('Your version of PHP does NOT have the openssl or mcrypt extension loaded.'), 'danger');
    }

    if (extension_loaded('intl')) {
        //echo alert_message( _l( 'Your version of PHP has the intl extension loaded.' ), 'success' );
    } else {
        $check = false;
        echo alert_message(_l('Your version of PHP does NOT have the intl or mcrypt extension loaded.'), 'danger');
    }

    if (extension_loaded('curl')) {
        //echo alert_message( _l( 'Your version of PHP has the curl extension loaded.' ), 'success' );
    } else {
        $check = false;
        echo alert_message(_l('Your version of PHP does NOT have the curl extension loaded.'), 'danger');
    }
    
    if (extension_loaded('dom')) {
        //echo alert_message( _l( 'Your version of PHP has the dom extension loaded.' ), 'success' );
    } else {
        $check = false;
        echo alert_message(_l('Your version of PHP does NOT have the dom extension loaded.'), 'danger');
    }
    
    if (extension_loaded('mbstring')) {
        //echo alert_message( _l( 'Your version of PHP has the mbstring extension loaded.' ), 'success' );
    } else {
        $check = false;
        echo alert_message(_l('Your version of PHP does NOT have the mbstring extension loaded.'), 'danger');
    }
    
    ?>
</div>
<?php
if ($check) {
    echo '<div class="alert alert-success" role="alert"><b>' . _l('Installation can continue as minimum requirements are met.') . '</b></div>';
    $out = "<p> 
               <a class='btn login100-form-btn' style='color:#000;padding-top:13px;' href='".url("/install/database")."'>"._l('Proced to Install')."</a>
           </p>";
} else {
    $out = '<div class="alert alert-danger" role="alert"><b>' . _l('Installation cannot continue as minimum requirements are not met.') . '</b></div>';
}

echo @$out;
?>
   </div>
 </div>
     
@endsection