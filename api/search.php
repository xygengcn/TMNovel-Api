<?php
header( 'Content-Type:application/json; charset=utf-8' );
/**
* 发送post请求
* @param string $url 请求地址
* @param array $post_data post键值对数据
* @return string
*/

function send_post( $url, $post_data ) {
    $postdata = http_build_query( $post_data );
    $options = array(
        'http' => array(
            'method' => 'POST',
            'header' => 'Content-type:application/x-www-form-urlencoded',
            'content' => $postdata,
            'timeout' => 15 * 60 // 超时时间（单位:s）
        )
    );
    $context = stream_context_create( $options );
    $result = file_get_contents( $url, false, $context );
    $result = iconv( 'gb2312', 'utf-8//IGNORE',  $result );
    return $result;
}
//测试
$post_data = array(
    'searchkey' => '牧神',
    'searchtype' => 'articlename'
);
echo send_post( 'https://www.aikantxt.la/modules/article/search.php', $post_data );
?>