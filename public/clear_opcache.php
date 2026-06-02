<?php
if (function_exists('opcache_reset')) {
    opcache_reset();
    echo "OpCache Reset Successful in " . __DIR__;
} else {
    echo "OpCache not enabled or function not exists";
}
?>
