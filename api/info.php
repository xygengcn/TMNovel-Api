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

//书名

function get_title( $html, $rule, $index ) {
    $title = '';
    $dom = new simple_html_dom;
    $dom->load( $html );
    if ( $str = $dom->find( $rule, $index ) )  $title = $str->innertext;
    $dom->clear();
    unset( $dom );
    return $title;
}

//封面

function get_img( $html, $rule, $index ) {
    $dom = new simple_html_dom;
    $dom->load( $html );
    $img = '';
    if ( $obj = $dom->find( $rule, $index ) ) {
        $img = $obj->src;
    }
    $dom->clear();
    unset( $dom );
    return $img;
}

//作者

function get_author( $html, $rule, $index, $reg ) {
    $result = '';
    $dom = new simple_html_dom;
    $dom->load( $html );
    if ( $obj = $dom->find( $rule, $index ) ) {
        $obj2 = $obj->innertext;
        preg_match( $reg,  $obj2, $result );
    }
    $dom->clear();
    unset( $dom );
    return $result[0];
}

//最后一次更新的时间

function get_lastTime( $html, $rule, $index, $reg ) {
    $result = '';
    $dom = new simple_html_dom;
    $dom->load( $html );
    if ( $obj = $dom->find( $rule, $index ) ) {
        $obj2 = $obj->innertext;
        preg_match( $reg,  $obj2, $result );
    }
    $dom->clear();
    unset( $dom );
    return $result[0];
}

//最后一章节

function get_lastSection( $html, $rule, $index ) {
    $result = '';
    $dom = new simple_html_dom;
    $dom->load( $html );
    if ( $obj = $dom->find( $rule, $index ) ) {
        $result = array( 'title'=>$obj->innertext, 'url'=>$obj->href );
    }
    $dom->clear();
    unset( $dom );
    return $result;
}

//简介

function get_intro( $html, $rule, $index, $reg ) {
    $result = '';
    $dom = new simple_html_dom;
    $dom->load( $html );
    if ( $obj = $dom->find( $rule, $index ) ) {
        $obj2 = $obj->innertext;
        $result = preg_replace( $reg, '',  $obj2 );
    }
    $dom->clear();
    unset( $dom );
    return $result;
}

$url = $_GET['url'];
$curl = $config['curl'];
$bookNameRuleDom = $config['bookNameRuleDom'];
$bookNameRuleIndex = $config['bookNameRuleIndex'];
$bookNameRuleRegs = $config['bookNameRuleRegs'];
$bookImageRuleDom = $config['bookImageRuleDom'];
$bookImageRuleIndex = $config['bookImageRuleIndex'];
$bookAuthorRuleDom = $config['bookAuthorRuleDom'];
$bookAuthorRuleIndex = $config['bookAuthorRuleIndex'];
$bookAuthorRuleReg = $config['bookAuthorRuleReg'];
$bookIntroRuleDom = $config['bookIntroRuleDom'];
$bookIntroRuleIndex = $config['bookIntroRuleIndex'];
$bookIntroRuleReg = $config['bookIntroRuleReg'];
$bookLastTimeRuleDom = $config['bookLastTimeRuleDom'];
$bookLastTimeRuleIndex = $config['bookLastTimeRuleIndex'];
$bookLastTimeRuleReg = $config['bookLastTimeRuleReg'];
$bookLastSectionRuleDom = $config['bookLastSectionRuleDom'];
$bookLastSectionRuleIndex = $config['bookLastSectionRuleIndex'];
$bookLastSectionRuleReg = $config['bookLastSectionRuleReg'];

if ( $curl ) {
    $html = curl_get( $url, true );
} else {
    $html = file_get( $url );
}
$title = get_title( $html, $bookNameRuleDom, $bookNameRuleIndex );
$author = get_author( $html, $bookAuthorRuleDom, $bookAuthorRuleIndex, $bookAuthorRuleReg );
$intro = get_intro( $html, $bookIntroRuleDom, $bookIntroRuleIndex, $bookIntroRuleReg );
$image = get_img( $html, $bookImageRuleDom, $bookImageRuleIndex );
$lastTime = get_lastTime( $html, $bookLastTimeRuleDom, $bookLastTimeRuleIndex, $bookLastTimeRuleReg );
$lastSection = get_lastSection( $html, $bookLastSectionRuleDom, $bookLastSectionRuleIndex, $bookLastSectionRuleReg );

echo json_encode( array(
    'title' =>$title,
    'author' =>$author,
    'intro'=>$intro,
    'image' =>$image,
    'url'=>$url,
    'lastTime'=>$lastTime,
    'lastSection'=> $lastSection,
) );