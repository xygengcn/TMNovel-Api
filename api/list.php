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

//目录

function get_list( $html,  $host, $rule ) {
    $dom = new simple_html_dom;
    $dom->load( $html );
    $list = [];
    if ( $str = $dom->find( $rule ) )
    foreach ( $str as $item ) {
        if ( !preg_match( '/(http|https):\/\/[\w.]+[\w\/]*[\w.]*\??[\w=&\+\%]*/is', $obj->href, $results ) ) {
            array_push( $list, array( 'title'=>$item->innertext, 'url'=>$host.$item->href ) );
        } else {
            array_push( $list, array( 'title'=>$item->innertext, 'url'=>$item->href ) );
        }

    }
    $dom->clear();
    unset( $dom );
    return $list;
}

$url = $_GET['url'];
$curl = $config['curl'];
$host = $config['host'];
$bookCatalogueRuleDom = $config['bookCatalogueRuleDom'];

if ( $curl ) {
    $html = curl_get( $url, true );
} else {
    $html = file_get( $url );
}
$list = get_list( $html, $host, $bookCatalogueRuleDom );

echo json_encode( $list );