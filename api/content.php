<?php
header( 'Content-Type:application/json; charset=utf-8' );
header( 'Access-Control-Allow-Origin:*' );
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

//返回正文

function get_content( $html, $rule, $index, $reg ) {
    $dom = new simple_html_dom;
    $dom->load( $html );
    if ( $obj = $dom->find( $rule,  $index ) ) {
        $content = $obj->innertext;
        $content = preg_replace( $reg, '',  $content );
    }

    $dom->clear();
    unset( $dom );
    return $content;
}

//章节名

function get_title( $html, $rule, $index ) {
    $dom = new simple_html_dom;
    $dom->load( $html );
    if ( $obj = $dom->find( $rule, $index ) ) $title = $obj->innertext;
    $dom->clear();
    unset( $dom );
    return $title;
}

//章节目录

function get_catalogue_url( $html, $rule, $index ) {
    $result = '';
    $dom = new simple_html_dom;
    $dom->load( $html );
    $url = array();
    if ( $obj = $dom->find( $rule, $index ) ) {
        $result = $obj->href;
    }
    $dom->clear();
    unset( $dom );
    return  $result;
}

//上一章

function get_previous_url( $html, $host, $rule, $index ) {
    $result = '';
    $dom = new simple_html_dom;
    $dom->load( $html );
    $url = array();
    if ( $obj = $dom->find( $rule, $index ) ) {
        if ( !preg_match( '/(http|https):\/\/[\w.]+[\w\/]*[\w.]*\??[\w=&\+\%]*/is', $obj->href, $results ) ) {
            $result = $host.$obj->href;
        } else {
            $result = $obj->href;
        }
    }
    $dom->clear();
    unset( $dom );

    return  $result;
}

//下一章

function get_next_url( $html, $host, $rule, $index ) {
    $result = '';
    $dom = new simple_html_dom;
    $dom->load( $html );
    $url = array();
    if ( $obj = $dom->find( $rule, $index ) ) {
        if ( !preg_match( '/(http|https):\/\/[\w.]+[\w\/]*[\w.]*\??[\w=&\+\%]*/is', $obj->href, $results ) ) {
            $result = $host.$obj->href;
        } else {
            $result = $obj->href;
        }
    }
    $dom->clear();
    unset( $dom );

    return  $result;
}

$url = $_GET['url'];
$host = $config['host'];
$curl = $config['curl'];
$chapterNameRuleDom = $config['chapterNameRuleDom'];
$chapterNameRuleIndex = $config['chapterNameRuleIndex'];
$chapterNameRuleReg = $config['chapterNameRuleReg'];
$chapterCatalogueUrlDom = $config['chapterCatalogueUrlDom'];
$chapterCatalogueUrlIndex = $config['chapterCatalogueUrlIndex'];
$chapterNextDom = $config['chapterNextDom'];
$chapterNextIndex = $config['chapterNextIndex'];
$chapterPreviousDom = $config['chapterPreviousDom'];
$chapterPreviousIndex = $config['chapterPreviousIndex'];
$chapterContentDom = $config['chapterContentDom'];
$chapterContentIndex = $config['chapterContentIndex'];
$chapterContentReg = $config['chapterContentReg'];

if ( $curl ) {
    $html = curl_get( $url, true );
} else {
    $html = file_get( $url );
}

$title = get_title( $html, $chapterNameRuleDom, $chapterNameRuleIndex );
$content = get_content( $html, $chapterContentDom, $chapterContentIndex, $chapterContentReg );
$previous = get_previous_url( $html, $host, $chapterPreviousDom, $chapterPreviousIndex );
$next = get_next_url( $html, $host, $chapterNextDom, $chapterNextIndex );
$catalogue = get_catalogue_url( $html, $chapterCatalogueUrlDom, $chapterCatalogueUrlIndex );

echo json_encode( array( 'title'=>$title, 'url'=>$url, 'catalogue'=>$catalogue, 'previousUrl'=>$previous, 'nextUrl'=>$next, 'content'=>$content ) );