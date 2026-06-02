<?php
$file = 'e:\WORKS\sarthakedgenewcode-final\database_dump.sql';
$content = file_get_contents($file);

// If I currently have the "garbled" version (which is U+2D2D ...), 
// it means I converted 1-byte chars as if they were 2-byte chars.
// But wait, if I want to fix it, I just need to get it to a clean state.

// Let's try to detect if it's actually just UTF-8 encoded "Chinese" now
// and try to get back to the ASCII. 
// Actually, it's safer to just ask the user to give me a second to fix the logic.

// Let's look at the first 100 bytes of the CURRENT file to be sure.
$sample = bin2hex(substr($content, 0, 100));
file_put_contents('e:\WORKS\sarthakedgenewcode-final\debug_hex.txt', $sample);
?>