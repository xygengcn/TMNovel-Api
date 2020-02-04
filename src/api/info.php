<?php
require_once '../index.php';
$title = get_title($html, $bookNameRuleDom, $bookNameRuleIndex);
$author = get_author($html, $bookAuthorRuleDom, $bookAuthorRuleIndex, $bookAuthorRuleReg);
$intro = get_intro($html, $bookIntroRuleDom, $bookIntroRuleIndex, $bookIntroRuleReg);
$image = get_img($html, $bookImageRuleDom, $bookImageRuleIndex);
$lastTime = get_lastTime($html, $bookLastTimeRuleDom, $bookLastTimeRuleIndex, $bookLastTimeRuleReg);
$lastSection = get_lastSection($html, $bookLastSectionRuleDom, $bookLastSectionRuleIndex, $bookLastSectionRuleReg);

echo json_encode(array(
    'title' => $title,
    'author' => $author,
    'intro' => $intro,
    'image' => $image,
    'url' => $url,
    'lastTime' => $lastTime,
    'lastSection' => $lastSection,
));
