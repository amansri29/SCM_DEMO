<?php defined("BASEPATH") OR exit("No direct script access allowed");


$active_group = "default";
$query_builder = TRUE;
$db["default"] = array(
"dsn"  => "",
"hostname" => ".", 
"username" => "scm_demo" ,
"password" => "Change@123",
"database" => "SCM_Demo2",
"dbdriver" => "sqlsrv",
"pconnect" => FALSE,
"db_debug" => (ENVIRONMENT !== "production"),
"cache_on" => FALSE,
"cachedir" => "",
"char_set" => "utf8",
"dbcollat" => "utf8_general_ci",
"swap_pre" => "",
"encrypt" => FALSE,
"compress" => FALSE,
"stricton" => FALSE,
"failover" => array(),
"save_queries" => TRUE
);
