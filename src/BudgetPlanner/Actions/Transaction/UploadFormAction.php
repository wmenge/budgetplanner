<?php

namespace BudgetPlanner\Actions\Transaction;

use Psr\Container\ContainerInterface;
use BudgetPlanner\Actions\BaseRenderAction;
use BudgetPlanner\Service\TransactionService;
use BudgetPlanner\Service\AssignmentRuleService;
use \BudgetPlanner\Model\Transaction;
use \BudgetPlanner\Model\Category;
use \BudgetPlanner\Model\Account;
use \BudgetPlanner\Model\AssignmentRule;


final class UploadFormAction extends BaseRenderAction
{
	public function __construct(ContainerInterface $c, AssignmentRuleService $ruleService, TransactionService $transactionService)
    {
        parent::__construct($c);
    	$this->ruleService = $ruleService;
        $this->transactionService = $transactionService;
    }

    public function renderContent($request, $args) {
        $filter = $request->getAttribute('filter', 'upload');
        //$match = $request->getAttribute('match', null);
        //$sort = $this->getQueryParam($request, 'sort', 'date');
        
        //$transactions = $this->getTransactionsFor($filter, $sort);

        //if ($match) {
        //    $transactions = $this->match($transactions);
        //}

        // Add own account status to data
        //foreach ($transactions as $transaction) {
        //    $transaction->ownAccount = $this->transactionService->ownAccount($transaction);
        //}

        return $this->renderer->fetch('transaction-upload-form-fragment.php', [
            'filter' => $filter,
            'uncategorized_count' => Transaction::whereNull('category_id')->count(),
            'categorized_count' => Transaction::whereNotNull('category_id')->count(),
            'own_accounts_count' => Transaction::whereIn('counter_account_iban', Account::pluck('iban'))->count()
          //  'transactions' => $transactions,
          //  'categories' => Category::orderBy('description')->get(),
          //  'match' => $match,

        ]);
    }

    protected function getTransactionsFor($filter, $sort) {

        switch ($filter) {
            case 'categorized':
                $result = Transaction::whereNotNull('category_id');
                break;
            
            case 'uncategorized':
                $result = Transaction::whereNull('category_id')->whereNotIn('counter_account_iban', Account::pluck('iban'));
                break;

            case 'own-accounts':
                $result = Transaction::whereIn('counter_account_iban', Account::pluck('iban'));
                break;

            default:
                $result = Transaction::all();
                break;
        }
        return $result->orderBy($sort)->get();
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