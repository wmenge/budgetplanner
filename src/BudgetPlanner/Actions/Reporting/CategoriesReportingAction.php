<?php

namespace BudgetPlanner\Actions\Reporting;

use BudgetPlanner\Actions\BaseRenderAction;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Response;
use Slim\Psr7\Request;
use Slim\Views\PhpRenderer;

use \BudgetPlanner\Model\Transaction;

// move to api namespace
final class ReportDataAction
{
    public function __invoke(Request $request, Response $response, $args): ResponseInterface
    {

    	$data = Transaction::groupBy('category_id')
		   //->selectRaw('sum(amount) as sum, category_id')
		   ->join('categories', 'transactions.category_id', '=', 'categories.id')
		   ->selectRaw('categories.description as category, sum(amount) as sum')
   			->get();
		   //->pluck('sum','category_id');

        //$data = [array('name' => 'Bob', 'age' => 60),array('name' => 'Alice', 'age' => 50)];
		$payload = json_encode($data);

		$response->getBody()->write($payload);
		return $response
		          ->withHeader('Content-Type', 'application/json');
	}
}