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
final class PeriodsReportingAction
{
    public function __invoke(Request $request, Response $response, $args): ResponseInterface
    {
    	$query = <<<QUERY
			select strftime('%Y-%m', datetime(date, 'unixepoch', 'localtime')) as period, sign, sum(amount) as sum
			from transactions
			--left join categories_tree on transactions.category_id = categories_tree.id
			--left join categories on categories_tree.path like "%'" || categories.id || "'%"  
			--where categories.parent_id = :category_id
			where transactions.counter_account_iban not in (select iban from accounts)
			group by period, sign
		QUERY;

		$data = DB::select(DB::raw($query));
        $payload = json_encode($data, JSON_PRETTY_PRINT | JSON_NUMERIC_CHECK);

		$response->getBody()->write($payload);
		return $response->withHeader('Content-Type', 'application/json');
	}

	protected function getQueryParam($request, $name, $default) {
        $params = $request->getQueryParams();
        return isset($params[$name]) ? $params[$name] : $default;
    }
}