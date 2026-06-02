<?php
$file = 'e:\WORKS\sarthakedgenewcode-final\database_dump.sql';
$content = file_get_contents($file);

// Step 1: Convert the "garbled" UTF-8 back to the raw bytes it came from.
// We treat the current UTF-8 as if it was successfully converted from UTF-16LE.
// So converting it back to UTF-16LE will give us the original single-byte sequence.
$original_bytes = mb_convert_encoding($content, 'UTF-16LE', 'UTF-8');

// Step 2: Now we have the raw ASCII bytes. 
// Let's filter out any remaining null bytes just in case there were real ones.
$clean_content = str_replace("\x00", "", $original_bytes);

// Step 3: Remove any BOMs that might be at the start
$clean_content = ltrim($clean_content, "\xFF\xFE\xEF\xBB\xBF");

file_put_contents($file, $clean_content);
echo "Database dump restored to plain text/UTF-8.\n";
?>