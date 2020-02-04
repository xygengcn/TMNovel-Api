<?php
header( 'Content-Type:application/json; charset=utf-8' );
header( 'Access-Control-Allow-Origin:http://localhost:8080' );
// *代表允许任何网址请求
header( 'Access-Control-Allow-Methods:POST,GET,OPTIONS,DELETE' );
// 允许请求的类型
header( 'Access-Control-Allow-Credentials: true' );
// 设置是否允许发送 cookies
header( 'Access-Control-Allow-Headers: Content-Type,Content-Length,Accept-Encoding,X-Requested-with, Origin' );
// 设置允许自定义请求头的字段
require './config.php' ;
require_once 'simple_html_dom.php';

$gzip = $config['gzip'];
$listUrl = $config['listUrl'];
$listRuleDom = $config['listRuleDom'];
$curl = $config['curl'];

function curl_get( $url, $gzip = false ) {
    $curl = curl_init( $url );
    curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );
    curl_setopt( $curl, CURLOPT_CONNECTTIMEOUT, 10 );
    if ( $gzip ) curl_setopt( $curl, CURLOPT_ENCODING, 'gzip' );
    $content = curl_exec( $curl );
    curl_close( $curl );
    return $content;
}

function file_get( $url ) {
    $html = file_get_contents( $url );
    $html = iconv( 'gb2312', 'utf-8//IGNORE', $html );
    return $html;
}

function get_list( $html, $rule ) {
    $dom = new simple_html_dom;
    $dom->load( $html );
    $list = array();
    if ( $str = $dom->find( $rule ) )
    foreach ( $str as $a ) {
        array_push( $list, array( 'title'=> $a->innertext, 'url'=>$a->href ) );
    }
    return $list;
}

if ( $curl ) {
    $html = curl_get( $listUrl, $gzip );

} else {
    $html = file_get( $listUrl );
}
echo json_encode( get_list( $html, $listRuleDom ) );