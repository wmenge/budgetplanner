<?php

use BudgetPlanner\Lib\DatabaseFacade;
use Illuminate\Container\Container as IlluminateContainer;
use Illuminate\Database\Connection;
use Illuminate\Database\Connectors\ConnectionFactory;
use Psr\Container\ContainerInterface;
use Slim\Views\PhpRenderer;

return [
    'settings' => (require __DIR__ . '/config-test.php'),
    'migrations' => (require  __DIR__ . '/../migrations/migration-config.php'),
    Connection::class => function (ContainerInterface $container) {
        return $container->get('db')->connection();
    },
    PDO::class => function (ContainerInterface $container) {
        $pdo = $container->get(Connection::class)->getPdo();
        $pdo->exec('PRAGMA foreign_keys = ON');
        return $pdo;
    },
    DatabaseFacade::class => function(ContainerInterface $container) {
        return new DatabaseFacade(
            $container->get(PDO::class),
            $container->get('migrations'),
            $container->get('settings')
        );
    },
    PhpRenderer::class => function(ContainerInterface $container) {
        return new PhpRenderer(__DIR__ . '/../templates/');
    },
    'db' => function (ContainerInterface $container) {
        $capsule = new \Illuminate\Database\Capsule\Manager;
        $capsule->addConnection($container->get('settings')['db']);
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
        return $capsule;
    }
];