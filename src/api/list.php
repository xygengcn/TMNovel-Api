<?php
require_once '../index.php';

echo json_encode(get_list($html, $host, $bookCatalogueRuleDom));
