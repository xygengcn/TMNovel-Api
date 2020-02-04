<?php
require_once '../index.php';
$title = get_title($html, $chapterNameRuleDom, $chapterNameRuleIndex);
$content = get_content_text($html, $chapterContentDom, $chapterContentIndex, $chapterContentReg);
$previous = get_previous_url($html, $host, $chapterPreviousDom, $chapterPreviousIndex);
$next = get_next_url($html, $host, $chapterNextDom, $chapterNextIndex);
$catalogue = get_catalogue_url($html, $chapterCatalogueUrlDom, $chapterCatalogueUrlIndex);
echo json_encode(array('title' => $title, 'url' => $url, 'catalogue' => $catalogue, 'previousUrl' => $previous, 'nextUrl' => $next, 'content' => $content));
