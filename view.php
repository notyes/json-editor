<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$file_save = __DIR__.'/food.json';
$dataList = file_get_contents( $file_save ,FILE_USE_INCLUDE_PATH);


echo '<pre>';
print_r( json_decode($dataList) );
echo '</pre>';
die();

