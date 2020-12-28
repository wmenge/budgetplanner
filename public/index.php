<?php
use Slim\Factory\AppFactory;

// Start PHP session
session_start(); //by default requires session storage

require __DIR__ . '/../vendor/autoload.php';

// Setup DI
$builder = new DI\ContainerBuilder();
$builder->addDefinitions(__DIR__ . '/../config/container.php');
$container = $builder->build();
// bad hack: start up eloquent
$container->get('db');
AppFactory::setContainer($container);

$pdo = $container->get(PDO::class);
$pdo->exec('PRAGMA foreign_keys = ON;');

/**
 * Instantiate App
 *
 * In order for the factory to work you need to ensure you have installed
 * a supported PSR-7 implementation of your choice e.g.: Slim PSR-7 and a supported
 * ServerRequest creator (included with Slim PSR-7)
 */
$app = AppFactory::create();

// Add Routing Middleware
$app->addRoutingMiddleware();
$app->addBodyParsingMiddleware();

/**
 * Add Error Handling Middleware
 *
 * @param bool $displayErrorDetails -> Should be set to false in production
 * @param bool $logErrors -> Parameter is passed to the default ErrorHandler
 * @param bool $logErrorDetails -> Display error details in error log
 * which can be replaced by a callable of your choice.
 
 * Note: This middleware should be added last. It will not handle any exceptions/errors
 * for middleware added after it.
 */
$errorMiddleware = $app->addErrorMiddleware(true, true, true);

// Register routes
(require __DIR__ . '/../config/routes.php')($app);

// Run app
$app->run();