<?php

/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * This file allows us to emulate Apache's "mod_rewrite" functionality from the
 * built-in PHP web server. This provides a convenient way to run a Laravel
 * application in container environments without separate web server software.
 */

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? ''
);

if ($uri !== '/' && file_exists(__DIR__.'/public'.$uri)) {
    return false;
}

require_once __DIR__.'/public/index.php';
