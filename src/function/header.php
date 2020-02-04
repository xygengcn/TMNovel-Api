<?php

header('Content-Type:application/json; charset=utf-8');
header('Access-Control-Allow-Origin:*');
// *代表允许任何网址请求
header('Access-Control-Allow-Methods:POST,GET,OPTIONS,DELETE');
// 允许请求的类型
header('Access-Control-Allow-Credentials: true');
// 设置是否允许发送 cookies
header('Access-Control-Allow-Headers: Content-Type,Content-Length,Accept-Encoding,X-Requested-with, Origin');
// 设置允许自定义请求头的字段

$gzip = $config['gzip'];
$listUrl = $config['listUrl'];
$listRuleDom = $config['listRuleDom'];
$curl = $config['curl'];
$host = $config['host'];
if ($_GET['url']) {
    $url = $_GET['url'];
} else {
    $url = $listUrl;
}
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

$bookCatalogueRuleDom = $config['bookCatalogueRuleDom'];
