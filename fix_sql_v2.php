<?php
$file = 'e:\WORKS\sarthakedgenewcode-final\database_dump.sql';
$content = file_get_contents($file);

// Check for UTF-16 Little Endian BOM (FF FE)
if (substr($content, 0, 2) === "\xFF\xFE") {
    // Convert from UTF-16LE to UTF-8
    $content = mb_convert_encoding(substr($content, 2), 'UTF-8', 'UTF-16LE');
} else {
    // If no BOM, just try to strip null bytes as a fallback
    $content = str_replace("\x00", "", $content);
}

// Remove any leading weird characters (BOMs that might have been converted incorrectly)
$content = ltrim($content, "\xEF\xBB\xBF");

file_put_contents($file, $content);
echo "Cleaned UTF-8 SQL file saved.\n";
?>