<?php

namespace BudgetPlanner\Actions\Transaction;

use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Response;
use Slim\Psr7\Request;
use Slim\Flash\Messages;

use \BudgetPlanner\Model\Transaction;
use \BudgetPlanner\Model\Category;

final class MatchAction
{
    protected $flash;
    
    public function __construct(Messages $flash)
    {
        $this->flash = $flash;
    }

    public function __invoke(Request $request, Response $response, $args): ResponseInterface
    {
    	$data = $request->getParsedBody();
    	$filter = $request->getAttribute('filter', 'uncategorized');

        $matchedTransactions = array_filter($data['category_id'], function($var) { return !empty($var); });

        foreach ($matchedTransactions as $transaction_id => $category_id) {
    		$transaction = Transaction::find($transaction_id);
    		$category = Category::find($category_id);
    		$transaction->category()->associate($category);
    		$transaction->save();	
        }

        $this->flash->addMessage('success', sprintf('updated %s transactions', count($matchedTransactions)));

        return $response->withHeader('Location', '/transactions/' . $filter)
                ->withStatus(303);
    }
}