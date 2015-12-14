<?php

// comment out the following line when deployed to production
error_reporting(E_ALL);

defined('BLOG_START') or define('BLOG_START', microtime(true));
defined('ROOT_DIR') or define('ROOT_DIR', realpath(__DIR__ . '/..'));

// comment out the following two lines when deployed to production
defined('APP_ENV') or define('APP_ENV', 'dev');
defined('APP_DEBUG') or define('APP_DEBUG', true);

require ROOT_DIR . '/bootstrap/autoload.php';
require ROOT_DIR . '/bootstrap/app.php';

try {
    // Create an application
    $app = new BlogApp();
    // Run the application
    $app->run();
} catch (Exception $e) {
    echo $e->getMessage();
}
