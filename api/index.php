<?php

/**
 * Vercel Serverless Function Entry Point for Laravel
 * 
 * Prepares writable storage in /tmp and delegates request handling to Laravel's public/index.php.
 */

$storageDirs = [
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/app/public',
    '/tmp/storage/logs',
    '/tmp/bootstrap_cache',
];

foreach ($storageDirs as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }
}

// Force Laravel to use the writable /tmp filesystem on serverless environments
putenv('LARAVEL_STORAGE_PATH=/tmp/storage');
$_ENV['LARAVEL_STORAGE_PATH'] = '/tmp/storage';
$_SERVER['LARAVEL_STORAGE_PATH'] = '/tmp/storage';

putenv('VIEW_COMPILED_PATH=/tmp/storage/framework/views');
putenv('APP_CONFIG_CACHE=/tmp/bootstrap_cache/config.php');
putenv('APP_EVENTS_CACHE=/tmp/bootstrap_cache/events.php');
putenv('APP_PACKAGES_CACHE=/tmp/bootstrap_cache/packages.php');
putenv('APP_ROUTES_CACHE=/tmp/bootstrap_cache/routes.php');
putenv('APP_SERVICES_CACHE=/tmp/bootstrap_cache/services.php');

// Forward request to Laravel standard front controller
require __DIR__ . '/../public/index.php';
