<?php
/**
 * Pop Web Bootstrap Application Framework (http://www.popphp.org/)
 *
 * @link       https://github.com/popphp/pop-bootstrap
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2009-2017 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.popphp.org/license     New BSD License
 */

use Pop\Application;
use App\Module;

/**
 * Display all errors when APPLICATION_ENV is development.
 *
 * @since   1.0.0
 */
if ( isset( $_SERVER['APPLICATION_ENV'] ) || $_SERVER['APPLICATION_ENV'] === 'development' ) {
    error_reporting( E_ALL );
    ini_set( 'display_errors', 1 );
}

/**
 * Composer autoloading.
 *
 * @since   1.0.0
 */
$autoloader = include __DIR__ . '/../vendor/autoload.php';

if ( ! class_exists( Application::class ) ) {
    throw new RuntimeException(
        "Unable to load application.\n"
        . "- Type `composer install` in your root directory if you are developing locally.\n"
    );
}

/**
 * Create main app object, register the app module and run the app.
 */
try {
    $app = new Application( $autoloader, include __DIR__ . '/../app/config/app.web.php' );
    $app->register( new Module() );
    $app->run();
} catch ( \Exception $exception ) {
    $app = new Module();
    $app->webError( $exception );
}