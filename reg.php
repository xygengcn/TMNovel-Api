<?php

//提取冒号后面
$str = '<p>作&nbsp;&nbsp;&nbsp;&nbsp;者：宅猪</p>';
preg_match( '/(?<=：)(.*)+/',  $str, $result );
$result = preg_replace( '/.*(?>：)+/', '',  $str );
// echo $result[0];

//删除a标签

$str2 = '111<a href="http">aaa</a>2222';
$result2 = preg_replace( '/<a[^>]*>(.*?)<\/a>/', '',  $str2 );
//echo $result2;

function get_content_reg( $html )
 {
    preg_match( '/(<div[^>]id="content"[^>]*>)(.*?)(<\/div>)/si', $html, $match );
    // $str = preg_replace( '/<p>(.*?)<\/p>/si', '', $match[0] );
    $str = preg_replace( '/---+.*(?=<\/div>)/si', '',  $match[0] );
    return  $str;
}
// echo get_content_reg( curl_get( $url, true ) );

// $url = 'https://www.aikantxt.la/xiaoshuodaquan/';
// $html = file_get_contents( $url );
// $html = iconv( 'gb2312', 'utf-8//IGNORE', $html );
// echo $html;

//提取域名
$url = 'http://www.aikantxt.la/xiaoshuodaquan/';
preg_match( '/(http|https):\/\/(www.)?(\w+(\.)?)+/is', $url, $results );
// print_r( $results[0] );

ob_end_clean();
//清空（擦除）缓冲区并关闭输出缓冲
ob_implicit_flush( 1 );
//将打开或关闭绝对（隐式）刷送。绝对（隐式）刷送将导致在每次输出调用后有一次刷送操作，以便不再需要对 flush() 的显式调用
$i = 4;
while( 1 ) {
    ++$i;
    //部分浏览器需要内容达到一定长度了才输出
    if ( $i === 1 ) {
        echo str_repeat( '<div></div>', 200 ).'<script>window.parent.foo</script>';
    } else {
        echo str_repeat( '<div></div>', 200 );
    }
    sleep( 1 );
}