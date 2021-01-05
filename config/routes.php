<?php

use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use BudgetPlanner\Middleware\AuthenticationMiddleware;

return function (App $app) {
    
    // Define app routes

    $app->group('', function (RouteCollectorProxy $group) {

        $group->get('/', BudgetPlanner\Actions\Transaction\ListAction::class);

        $group->group('/categories', function (RouteCollectorProxy $group) {

            // Categories

            $group->get('', BudgetPlanner\Actions\Category\ListAction::class);
            $group->get('/new', BudgetPlanner\Actions\Category\EditFormAction::class);
            $group->get('/{id}', BudgetPlanner\Actions\Category\EditFormAction::class);
            // TODO: Should be put, but cannot be natively sent by HTML form
            $group->post('', BudgetPlanner\Actions\Category\SaveAction::class);
            // TODO: Should be DELETE, but cannot be natively sent by HTML form
            $group->get('/{id}/delete', BudgetPlanner\Actions\Category\DeleteAction::class);

            // Assignment Rules

            $group->get('/{category_id}/rules', BudgetPlanner\Actions\AssignmentRules\ListAction::class);
            $group->get('/{category_id}/rules/new', BudgetPlanner\Actions\AssignmentRules\NewFormAction::class);
            $group->get('/{category_id}/rules/{rule_id}', BudgetPlanner\Actions\AssignmentRules\EditFormAction::class);
            // TODO: Should be put, but cannot be natively sent by HTML form
            $group->post('/{category_id}/rules', BudgetPlanner\Actions\AssignmentRules\SaveAction::class);
            // TODO: Should be DELETE, but cannot be natively sent by HTML form
            $group->get('/{category_id}/rules/{rule_id}/delete', BudgetPlanner\Actions\AssignmentRules\DeleteAction::class);

        });

        // Tags

        $group->group('/tags', function (RouteCollectorProxy $group) {
            $group->get('', BudgetPlanner\Actions\Tag\ListAction::class);
            $group->get('/new', BudgetPlanner\Actions\Tag\NewFormAction::class);
            $group->get('/{id}', BudgetPlanner\Actions\Tag\EditFormAction::class);
            // TODO: Should be put, but cannot be natively sent by HTML form
            $group->post('', BudgetPlanner\Actions\Tag\SaveAction::class);
            // TODO: Should be DELETE, but cannot be natively sent by HTML form
            $group->get('/{id}/delete', BudgetPlanner\Actions\Tag\DeleteAction::class);
        });

        // Accounts

        $group->group('/accounts', function (RouteCollectorProxy $group) {

            $group->get('', BudgetPlanner\Actions\Account\ListAction::class);
            $group->get('/new', BudgetPlanner\Actions\Account\EditFormAction::class);
            $group->get('/{id}', BudgetPlanner\Actions\Account\EditFormAction::class);
            // TODO: Should be put, but cannot be natively sent by HTML form
            $group->post('', BudgetPlanner\Actions\Account\SaveAction::class);
            // TODO: Should be DELETE, but cannot be natively sent by HTML form
            $group->get('/{id}/delete', BudgetPlanner\Actions\Account\DeleteAction::class);

        });

        // Transactions

        $group->group('/transactions', function (RouteCollectorProxy $group) {

            $group->get('[/{filter:categorized|uncategorized|own-accounts}]', BudgetPlanner\Actions\Transaction\ListAction::class);

            ///$group->get('/categorized/{categoryDescription}', BudgetPlanner\Actions\Transaction\ListAction::class);

            $group->get('/{filter:categorized|uncategorized|own-accounts}/{match:match}', BudgetPlanner\Actions\Transaction\ListAction::class);
            $group->post('/{filter:categorized|uncategorized|own-accounts}/match', BudgetPlanner\Actions\Transaction\MatchAction::class);
            
            $group->get('/{id:[0-9]+}', BudgetPlanner\Actions\Transaction\EditFormAction::class);
            // TODO: Should be put, but cannot be natively sent by HTML form
            $group->post('', BudgetPlanner\Actions\Transaction\SaveAction::class);
            $group->get('/upload', BudgetPlanner\Actions\Transaction\UploadFormAction::class);
            $group->post('/upload', BudgetPlanner\Actions\Transaction\UploadAction::class);
            // TODO: Should be DELETE, but cannot be natively sent by HTML form
            $group->get('/{id}/delete', BudgetPlanner\Actions\Transaction\DeleteAction::class);

            $group->post('/{id:[0-9]+}/tags', BudgetPlanner\Actions\Transaction\AddTagAction::class);
            $group->post('/{id:[0-9]+}/tags/{tag_id:[0-9]+}/delete', BudgetPlanner\Actions\Transaction\RemoveTagAction::class);

        });

        // Reporting

        $group->get('/reporting', BudgetPlanner\Actions\Reporting\ReportAction::class);
        $group->get('/api/reporting/categories[/{categoryDescription}]', BudgetPlanner\Actions\Api\Reporting\CategoriesReportingAction::class);

        $group->get('/api/reporting/categories/{from}/{to}', BudgetPlanner\Actions\Api\Reporting\CategoriesReportingAction::class);

    })->add(AuthenticationMiddleware::class);

    // Security

    $app->get('/login', BudgetPlanner\Actions\Oauth2\LoginFormAction::class);
    $app->get('/oauth2/{provider}/login', BudgetPlanner\Actions\Oauth2\LoginAction::class);
    $app->get('/oauth2/{provider}/callback', BudgetPlanner\Actions\Oauth2\CallbackAction::class);

};
