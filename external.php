<?php
// Remove the query string
$_SERVER['QUERY_STRING'] = '';
// Include the codeigniter framework
define("REQUEST", "external");
ob_start();
require('index.php');
ob_end_clean();
?>