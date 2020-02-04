<?php
define('Root_Path', dirname(__FILE__));

require_once Root_Path . '/config/config.php';
require_once Root_Path . '/lib/simple_html_dom.php';
require_once Root_Path . '/function/header.php';
require_once Root_Path . '/function/function.php';


if ($curl) {
    $html = curl_get($url, true);
} else {
    $html = file_get($url);
}
