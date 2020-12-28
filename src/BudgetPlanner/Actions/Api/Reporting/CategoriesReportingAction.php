<?php

namespace BudgetPlanner\Actions\Api\Reporting;

use BudgetPlanner\Actions\BaseRenderAction;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Response;
use Slim\Psr7\Request;
use Slim\Views\PhpRenderer;

use \BudgetPlanner\Model\Transaction;

// move to api namespace
final class CategoriesReportingAction
{
    public function __invoke(Request $request, Response $response, $args): ResponseInterface
    {
    //	print_r($request->getQueryParams());
    	$data = Transaction::groupBy('category_id')
		   ->leftJoin('categories', 'transactions.category_id', '=', 'categories.id')
		   ->selectRaw('CASE WHEN categories.description IS NULL THEN "Uncategorized" ELSE categories.description END as category, sum(amount) as sum')
   			->get();

        $payload = json_encode($data);

		$response->getBody()->write($payload);
		return $response
		          ->withHeader('Content-Type', 'application/json');
	}
}