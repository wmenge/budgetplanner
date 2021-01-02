<?php

use Slim\App;

return function (App $app) {
    
    // Define app routes

    $app->get('/', BudgetPlanner\Actions\Transaction\ListAction::class);
    
    // Categories

    $app->get('/categories', BudgetPlanner\Actions\Category\ListAction::class);
    $app->get('/categories/new', BudgetPlanner\Actions\Category\NewFormAction::class);
    $app->get('/categories/{id}', BudgetPlanner\Actions\Category\EditFormAction::class);
    // TODO: Should be put, but cannot be natively sent by HTML form
    $app->post('/categories', BudgetPlanner\Actions\Category\SaveAction::class);
    // TODO: Should be DELETE, but cannot be natively sent by HTML form
    $app->get('/categories/{id}/delete', BudgetPlanner\Actions\Category\DeleteAction::class);

    // Tags

    $app->get('/tags', BudgetPlanner\Actions\Tag\ListAction::class);
    $app->get('/tags/new', BudgetPlanner\Actions\Tag\NewFormAction::class);
    $app->get('/tags/{id}', BudgetPlanner\Actions\Tag\EditFormAction::class);
    // TODO: Should be put, but cannot be natively sent by HTML form
    $app->post('/tags', BudgetPlanner\Actions\Tag\SaveAction::class);
    // TODO: Should be DELETE, but cannot be natively sent by HTML form
    $app->get('/tags/{id}/delete', BudgetPlanner\Actions\Tag\DeleteAction::class);

    // Assignment Rules

    $app->get('/categories/{category_id}/rules', BudgetPlanner\Actions\AssignmentRules\ListAction::class);
    $app->get('/categories/{category_id}/rules/new', BudgetPlanner\Actions\AssignmentRules\NewFormAction::class);
    $app->get('/categories/{category_id}/rules/{rule_id}', BudgetPlanner\Actions\AssignmentRules\EditFormAction::class);
    // TODO: Should be put, but cannot be natively sent by HTML form
    $app->post('/categories/{category_id}/rules', BudgetPlanner\Actions\AssignmentRules\SaveAction::class);
    // TODO: Should be DELETE, but cannot be natively sent by HTML form
    $app->get('/categories/{category_id}/rules/{rule_id}/delete', BudgetPlanner\Actions\AssignmentRules\DeleteAction::class);
    
    // Accounts

    $app->get('/accounts', BudgetPlanner\Actions\Account\ListAction::class);
    $app->get('/accounts/new', BudgetPlanner\Actions\Account\EditFormAction::class);
    $app->get('/accounts/{id}', BudgetPlanner\Actions\Account\EditFormAction::class);
    // TODO: Should be put, but cannot be natively sent by HTML form
    $app->post('/accounts', BudgetPlanner\Actions\Account\SaveAction::class);
    // TODO: Should be DELETE, but cannot be natively sent by HTML form
    $app->get('/accounts/{id}/delete', BudgetPlanner\Actions\Account\DeleteAction::class);

    // Transactions

    $app->get('/transactions[/{filter:categorized|uncategorized|own-accounts}]', BudgetPlanner\Actions\Transaction\ListAction::class);

    $app->get('/transactions/categorized/{categoryDescription}', BudgetPlanner\Actions\Transaction\ListAction::class);

    $app->get('/transactions/{filter:categorized|uncategorized}/{match:match}', BudgetPlanner\Actions\Transaction\ListAction::class);
    $app->post('/transactions/{filter:categorized|uncategorized}/match', BudgetPlanner\Actions\Transaction\MatchAction::class);
    
    $app->get('/transactions/{id:[0-9]+}', BudgetPlanner\Actions\Transaction\EditFormAction::class);
    // TODO: Should be put, but cannot be natively sent by HTML form
    $app->post('/transactions', BudgetPlanner\Actions\Transaction\SaveAction::class);
    $app->get('/transactions/upload', BudgetPlanner\Actions\Transaction\UploadFormAction::class);
    $app->post('/transactions/upload', BudgetPlanner\Actions\Transaction\UploadAction::class);
    // TODO: Should be DELETE, but cannot be natively sent by HTML form
    $app->get('/transactions/{id}/delete', BudgetPlanner\Actions\Transaction\DeleteAction::class);

    $app->post('/transactions/{id:[0-9]+}/tags', BudgetPlanner\Actions\Transaction\AddTagAction::class);
    $app->post('/transactions/{id:[0-9]+}/tags/{tag_id:[0-9]+}/delete', BudgetPlanner\Actions\Transaction\RemoveTagAction::class);

    // Reporting

    $app->get('/reporting', BudgetPlanner\Actions\Reporting\ReportAction::class);
    $app->get('/api/reporting/categories[/{categoryDescription}]', BudgetPlanner\Actions\Api\Reporting\CategoriesReportingAction::class);

    $app->get('/api/reporting/categories/{from}/{to}', BudgetPlanner\Actions\Api\Reporting\CategoriesReportingAction::class);

};
