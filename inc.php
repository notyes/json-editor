<?php 

$isSecure = false;
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
    $isSecure = true;
}
elseif (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' || !empty($_SERVER['HTTP_X_FORWARDED_SSL']) && $_SERVER['HTTP_X_FORWARDED_SSL'] == 'on') {
    $isSecure = true;
}
$REQUEST_PROTOCOL = $isSecure ? 'https' : 'http';


define('ABSPATH',  str_replace('\\', '/', realpath(dirname(__FILE__) )) . '/');
define('DOCROOT', rtrim(str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']) . '/', '/'));
define('DOMAIN', $REQUEST_PROTOCOL.'://' . $_SERVER['HTTP_HOST'] );
define('ABSURL', DOMAIN . str_replace(DOCROOT, '', ABSPATH));

