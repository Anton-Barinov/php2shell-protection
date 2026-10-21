<?php
// Compatible with PHP 5.2+
header('Content-Type: text/plain; charset=utf-8');
echo "PHP_EXECUTED\n";
echo "Method: " . $_SERVER['REQUEST_METHOD'] . "\n";
echo "Content-Type: " . (isset($_SERVER['CONTENT_TYPE']) ? $_SERVER['CONTENT_TYPE'] : 'none') . "\n";
echo "POST fields: " . count($_POST) . "\n";
echo "FILES: " . count($_FILES) . "\n";
?>
