<?php
function curl_get($url, $gzip = false)
{
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
    if ($gzip) curl_setopt($curl, CURLOPT_ENCODING, 'gzip');
    $content = curl_exec($curl);
    curl_close($curl);
    return $content;
}

function file_get($url)
{
    $html = file_get_contents($url);
    $html = iconv('gb2312', 'utf-8//IGNORE', $html);
    return $html;
}

//获取书单

function get_All($html, $rule)
{
    $dom = new simple_html_dom;
    $dom->load($html);
    $list = array();
    if ($str = $dom->find($rule))
        foreach ($str as $a) {
            array_push($list, array('title' => $a->innertext, 'url' => $a->href));
        }
    return $list;
}

//返回正文

function get_content_text($html, $rule, $index, $reg)
{
    $dom = new simple_html_dom;
    $dom->load($html);
    if ($obj = $dom->find($rule,  $index)) {
        $content = $obj->innertext;
        $content = preg_replace($reg, '',  $content);
    }

    $dom->clear();
    unset($dom);
    return $content;
}

//章节名

function get_title($html, $rule, $index)
{
    $dom = new simple_html_dom;
    $dom->load($html);
    if ($obj = $dom->find($rule, $index)) $title = $obj->innertext;
    $dom->clear();
    unset($dom);
    return $title;
}

//章节目录

function get_catalogue_url($html, $rule, $index)
{
    $result = '';
    $dom = new simple_html_dom;
    $dom->load($html);
    $url = array();
    if ($obj = $dom->find($rule, $index)) {
        $result = $obj->href;
    }
    $dom->clear();
    unset($dom);
    return  $result;
}

//上一章

function get_previous_url($html, $host, $rule, $index)
{
    $result = '';
    $dom = new simple_html_dom;
    $dom->load($html);
    $url = array();
    if ($obj = $dom->find($rule, $index)) {
        if (!preg_match('/(http|https):\/\/[\w.]+[\w\/]*[\w.]*\??[\w=&\+\%]*/is', $obj->href, $results)) {
            $result = $host . $obj->href;
        } else {
            $result = $obj->href;
        }
    }
    $dom->clear();
    unset($dom);

    return  $result;
}

//下一章

function get_next_url($html, $host, $rule, $index)
{
    $result = '';
    $dom = new simple_html_dom;
    $dom->load($html);
    $url = array();
    if ($obj = $dom->find($rule, $index)) {
        if (!preg_match('/(http|https):\/\/[\w.]+[\w\/]*[\w.]*\??[\w=&\+\%]*/is', $obj->href, $results)) {
            $result = $host . $obj->href;
        } else {
            $result = $obj->href;
        }
    }
    $dom->clear();
    unset($dom);

    return  $result;
}
//书名

function get_name($html, $rule, $index)
{
    $title = '';
    $dom = new simple_html_dom;
    $dom->load($html);
    if ($str = $dom->find($rule, $index))  $title = $str->innertext;
    $dom->clear();
    unset($dom);
    return $title;
}

//封面

function get_img($html, $rule, $index)
{
    $dom = new simple_html_dom;
    $dom->load($html);
    $img = '';
    if ($obj = $dom->find($rule, $index)) {
        $img = $obj->src;
    }
    $dom->clear();
    unset($dom);
    return $img;
}

//作者

function get_author($html, $rule, $index, $reg)
{
    $result = '';
    $dom = new simple_html_dom;
    $dom->load($html);
    if ($obj = $dom->find($rule, $index)) {
        $obj2 = $obj->innertext;
        preg_match($reg,  $obj2, $result);
    }
    $dom->clear();
    unset($dom);
    return $result[0];
}

//最后一次更新的时间

function get_lastTime($html, $rule, $index, $reg)
{
    $result = '';
    $dom = new simple_html_dom;
    $dom->load($html);
    if ($obj = $dom->find($rule, $index)) {
        $obj2 = $obj->innertext;
        preg_match($reg,  $obj2, $result);
    }
    $dom->clear();
    unset($dom);
    return $result[0];
}

//最后一章节

function get_lastSection($html, $rule, $index)
{
    $result = '';
    $dom = new simple_html_dom;
    $dom->load($html);
    if ($obj = $dom->find($rule, $index)) {
        $result = array('title' => $obj->innertext, 'url' => $obj->href);
    }
    $dom->clear();
    unset($dom);
    return $result;
}

//简介

function get_intro($html, $rule, $index, $reg)
{
    $result = '';
    $dom = new simple_html_dom;
    $dom->load($html);
    if ($obj = $dom->find($rule, $index)) {
        $obj2 = $obj->innertext;
        $result = preg_replace($reg, '',  $obj2);
    }
    $dom->clear();
    unset($dom);
    return $result;
}

//目录

function get_list($html,  $host, $rule)
{
    $dom = new simple_html_dom;
    $dom->load($html);
    $list = [];
    if ($str = $dom->find($rule))
        foreach ($str as $item) {
            if (!preg_match('/(http|https):\/\/[\w.]+[\w\/]*[\w.]*\??[\w=&\+\%]*/is', $item->href, $results)) {
                array_push($list, array('title' => $item->innertext, 'url' => $host . $item->href));
            } else {
                array_push($list, array('title' => $item->innertext, 'url' => $item->href));
            }
        }
    $dom->clear();
    unset($dom);
    return $list;
}
