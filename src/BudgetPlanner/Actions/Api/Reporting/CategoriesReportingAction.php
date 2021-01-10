<?php

namespace BudgetPlanner\Actions\Api\Reporting;

use BudgetPlanner\Actions\BaseRenderAction;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Response;
use Slim\Psr7\Request;
use Slim\Views\PhpRenderer;

use \BudgetPlanner\Model\Transaction;
use \BudgetPlanner\Model\Account;
use \BudgetPlanner\Model\Category;

use Illuminate\Database\Capsule\Manager as DB;

// move to api namespace
final class CategoriesReportingAction
{
    public function __invoke(Request $request, Response $response, $args): ResponseInterface
    {
    	$params = $request->getQueryParams();

    	$query = DB::table('transactions')
			->select(DB::raw('categories.id, CASE WHEN categories.description IS NULL THEN "Uncategorized" ELSE categories.description END as category, sum(amount) as sum'))
			->leftJoin('categories_tree', 'transactions.category_id', '=', 'categories_tree.id')
			->leftJoin('categories', 'categories_tree.path', 'like', DB::raw('"%\'" || categories.id || "\'%"'))
			->whereNotIn('transactions.counter_account_iban', function($query) {
               $query->select('iban')->from('accounts');
            })
			->groupBy('categories.id');

		if ($params['sign']) {
			$query = $query->where('sign', '=', $params['sign']);
		}

    	if ($params['category_id']) {
	    	$query = $query->where('categories.parent_id', '=', $params['category_id']);
		} else {
			$query = $query->whereNull('categories.parent_id');
		}

		if ($params['month']) {
			$query = $query->where(DB::raw("strftime('%m-%Y', datetime(date, 'unixepoch', 'localtime'))"), '=', $params['month']);
		}

		//DB::enableQueryLog(); // Enable query log
		$data = $query->get();
		//print_r(DB::getQueryLog()); // Show results of log

       	$payload = json_encode($data, JSON_PRETTY_PRINT | JSON_NUMERIC_CHECK);
		$response->getBody()->write($payload);
		return $response->withHeader('Content-Type', 'application/json');
	}
}