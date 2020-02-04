<?php
$json_string = file_get_contents( 'config.json' );

$configs = json_decode( $json_string, true );

$config = $configs[1];

// $config = array(
//     'name'=>'铅笔小说',
//     'host'=>'https://www.x23qb.com',
//     'curl'=>false,
//     'gzip'=>true,
//     'listUrl'=>'https://www.x23qb.com/book/',
//     'listRuleDom'=>'#main .listlie a',
// );