<?php

namespace BudgetPlanner\Actions\Transaction;

use BudgetPlanner\Actions\BaseRenderAction;
use Slim\Views\PhpRenderer;
use Slim\Flash\Messages;
use BudgetPlanner\Service\TransactionService;
use BudgetPlanner\Service\AssignmentRuleService;
use \BudgetPlanner\Model\Transaction;
use \BudgetPlanner\Model\Category;
use \BudgetPlanner\Model\AssignmentRule;


final class ListAction extends BaseRenderAction
{
	public function __construct(PhpRenderer $renderer, AssignmentRuleService $ruleService, TransactionService $transactionService, Messages $flash)
    {
    	$this->renderer = $renderer;
        $this->ruleService = $ruleService;
        $this->transactionService = $transactionService;
        $this->flash = $flash;
    }

    public function renderContent($request, $args) {
        $filter = $request->getAttribute('filter', 'uncategorized');
        $match = $request->getAttribute('match', null);

        $transactions = $this->getTransactionsFor($filter);

        if ($match) {
            $transactions = $this->match($transactions);
        }

        // Add own account status to data
        foreach ($transactions as $transaction) {
            $transaction->ownAccount = $this->transactionService->ownAccount($transaction);
        }

        return $this->renderer->fetch('transaction-list-fragment.php', [
            'filter' => $filter,
            'uncategorized_count' => Transaction::whereNull('category_id')->count(),
            'categorized_count' => Transaction::whereNotNull('category_id')->count(),
            'transactions' => $transactions,
            'categories' => Category::orderBy('description')->get(),
            'match' => $match,

        ]);
    }

    protected function getTransactionsFor($filter) {
        return ($filter == 'categorized' ? Transaction::whereNotNull('category_id') : Transaction::whereNull('category_id'))->get();
    }

    protected function match($transactions) {

        $transactions = $this->ruleService->match($transactions, AssignmentRule::all());

        // TODO: Nice way
        $matchedTransactions = 0;

        foreach ($transactions as $transaction) {
            if ($transaction->category) $matchedTransactions++;
        }

        $this->flash->addMessageNow('success', sprintf('found %s matches', $matchedTransactions));

        return $transactions;
    }
}