<?php
require_once('../../include/session.php');
ini_set('display_errors', '0');
/*
if (extension_loaded('zlib') && !ini_get('zlib.output_compression')){
    header('Content-Encoding: gzip');
    ob_start('ob_gzhandler');
}
else
*/
    header("Content-type: text/javascript; charset: utf-8");
header("Cache-Control: must-revalidate");

$offset = 60 * 60 * 3;
$ExpStr = "Expires: " .
gmdate("D, d M Y H:i:s",
time() + $offset) . " GMT";
header($ExpStr);
include('../../include/langJS.php');
include('siparis.js');
include('jquery.elevateZoom-3.0.8.min.js');
include('jquery.fancybox.pack.js');
include('jquery.autocomplete.pack.js');
include('passrev.js');
include('jquery.mask.min.js');
include('others.js');
include('site.js');
?>