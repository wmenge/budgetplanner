<?php

namespace BudgetPlanner\Actions\Transaction;

use BudgetPlanner\Actions\BaseRenderAction;

use \BudgetPlanner\Model\Transaction;
use \BudgetPlanner\Model\Category;

use Slim\Views\PhpRenderer;
use Slim\Flash\Messages;
use BudgetPlanner\Service\AssignmentRuleService;
use \BudgetPlanner\Model\AssignmentRule;

final class ListAction extends BaseRenderAction
{
	public function __construct(PhpRenderer $renderer, AssignmentRuleService $service, Messages $flash)
    {
    	$this->renderer = $renderer;
        $this->service = $service;
        $this->flash = $flash;
    }

    public function renderContent($request, $args) {

        $filter = $request->getAttribute('filter', 'uncategorized');
        $match = $request->getAttribute('match', null);

        $transactions = ($filter == 'categorized' ? Transaction::whereNotNull('category_id') : Transaction::whereNull('category_id'))->get();

        
        if ($match) {
            $transactions = $this->service->match($transactions, AssignmentRule::all());

            // TODO: Nice way

            $matchedTransactions = 0;

            foreach ($transactions as $transaction) {
                if ($transaction->category) $matchedTransactions++;
            }

            $this->flash->addMessageNow('success', sprintf('found %s matches', $matchedTransactions));
        }

        return $this->renderer->fetch('transaction-list-fragment.php', [
            'filter' => $filter,
            'uncategorized_count' => Transaction::whereNull('category_id')->count(),
            'categorized_count' => Transaction::whereNotNull('category_id')->count(),
            'transactions' => $transactions,
            'categories' => Category::all(),
            'match' => $match
        ]);
    }
}