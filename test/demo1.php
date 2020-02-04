<?php

function file_get($url)
{
    $html = file_get_contents($url);
    $html = iconv('gb2312', 'utf-8//IGNORE', $html);
    return $html;
}


echo file_get('https://www.aikantxt.la/xiaoshuodaquan/');
