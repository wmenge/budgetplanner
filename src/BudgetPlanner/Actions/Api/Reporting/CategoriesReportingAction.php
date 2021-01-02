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

//use Illuminate\Support\Facades\DB;
use Illuminate\Database\Capsule\Manager as DB;

// move to api namespace
final class CategoriesReportingAction
{
    public function __invoke(Request $request, Response $response, $args): ResponseInterface
    {
    	$categoryDescription = $request->getAttribute('categoryDescription', null);

    	if ($categoryDescription) {

	    	$category = Category::where('description', $categoryDescription)->first();

	    	$query = <<<QUERY
				select categories.id, CASE WHEN categories.description IS NULL THEN "Uncategorized" ELSE categories.description END as category, sum(amount) as sum
				from transactions
				left join categories_tree on transactions.category_id = categories_tree.id
				left join categories on categories_tree.path like "%'" || categories.id || "'%"  
				where categories.parent_id = :category_id
				and transactions.counter_account_iban not in (select iban from accounts)
				group by categories.id
			QUERY;

			$data = DB::select(DB::raw($query), [ 'category_id' => $category->id ]);

		} else {

			$query = <<<QUERY
				select categories.id, CASE WHEN categories.description IS NULL THEN "Uncategorized" ELSE categories.description END as category, sum(amount) as sum
				from transactions
				left join categories_tree on transactions.category_id = categories_tree.id
				left join categories on categories_tree.path like "%'" || categories.id || "'%"  
				where categories.parent_id is null
				and transactions.counter_account_iban not in (select iban from accounts)
				group by categories.id
			QUERY;

			$data = DB::select(DB::raw($query));

		}

        $payload = json_encode($data);

		$response->getBody()->write($payload);
		return $response->withHeader('Content-Type', 'application/json');
	}

	private function getDescendants($id) {
		$categories = Category::select('id', 'parent_id')->get()->toArray();

		print_r($categories);

		$descendants = [];



	}

	private function getRootCategories() {
		return Category::select('id')->where('parent_id', null)->pluck('id')->toArray();
	}
}