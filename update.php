<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include __DIR__.'/inc.php';

if ( empty( $_GET['type'] ) ) {
    header('Location: '.ABSURL); 
}else if( ! in_array( $_GET['type'] , array( 'food', 'fair' ) ) ){
    header('Location: '.ABSURL); 
}


if (! empty( $_POST['param'] )) {
    $myfile = fopen($_GET['type'].".json", "w") or die("Unable to open file!");
    fwrite($myfile, $_POST['param']);
    fclose($myfile);
}



