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
    $app->get('/accounts/new', BudgetPlanner\Actions\Account\NewFormAction::class);
    $app->get('/accounts/{id}', BudgetPlanner\Actions\Account\EditFormAction::class);
    // TODO: Should be put, but cannot be natively sent by HTML form
    $app->post('/accounts', BudgetPlanner\Actions\Account\SaveAction::class);
    // TODO: Should be DELETE, but cannot be natively sent by HTML form
    $app->get('/accounts/{id}/delete', BudgetPlanner\Actions\Account\DeleteAction::class);

    // Transactions

    $app->get('/transactions[/{filter:categorized|uncategorized}]', BudgetPlanner\Actions\Transaction\ListAction::class);

    $app->get('/transactions/{filter:categorized|uncategorized}/{match:match}', BudgetPlanner\Actions\Transaction\ListAction::class);
    $app->post('/transactions/{filter:categorized|uncategorized}/match', BudgetPlanner\Actions\Transaction\MatchAction::class);
    //$app->get('/accounts/new', BudgetPlanner\Actions\Transaction\NewFormAction::class);
    

    $app->get('/transactions/{id:[0-9]+}', BudgetPlanner\Actions\Transaction\EditFormAction::class);
    // TODO: Should be put, but cannot be natively sent by HTML form
    $app->post('/transactions', BudgetPlanner\Actions\Transaction\SaveAction::class);
    $app->post('/transactions/upload', BudgetPlanner\Actions\Transaction\UploadAction::class);
    // TODO: Should be DELETE, but cannot be natively sent by HTML form
    $app->get('/transactions/{id}/delete', BudgetPlanner\Action\Transaction\DeleteAction::class);

    // Reporting

    $app->get('/reporting', BudgetPlanner\Actions\Reporting\ReportAction::class);
    $app->get('/api/reporting/categories', BudgetPlanner\Actions\Api\Reporting\CategoriesReportingAction::class);

    $app->get('/api/reporting/categories/{from}/{to}', BudgetPlanner\Actions\Api\Reporting\CategoriesReportingAction::class);

};
