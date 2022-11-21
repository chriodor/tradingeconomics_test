<?php

mb_internal_encoding('UTF-8');
session_start();
/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/

$clientAuth = ""; // <---- API key goes here

if (is_file("../functions/functions.php")) {
    include_once "../functions/functions.php";
}

$params_from_get = $params_from_post = $post_screen_array = array();
if (!empty($_GET)) {
    foreach ($_GET as $key => $gets) {
        $params_from_get[htmlspecialchars($key)] = htmlspecialchars($gets);
    }
}

if (!empty($_POST)) {
    recursivePostArray($_POST, "post_screen_array", $post_screen_array);
    $params_from_post = $post_screen_array;
}

