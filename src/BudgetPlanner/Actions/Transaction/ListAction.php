<?php

namespace BudgetPlanner\Actions\Transaction;

use Psr\Container\ContainerInterface;
use BudgetPlanner\Actions\BaseRenderAction;
use BudgetPlanner\Service\TransactionService;
use BudgetPlanner\Service\AssignmentRuleService;
use \BudgetPlanner\Model\Transaction;
use \BudgetPlanner\Model\Category;
use \BudgetPlanner\Model\CategoryTreeItem;
use \BudgetPlanner\Model\Account;
use \BudgetPlanner\Model\AssignmentRule;

use Illuminate\Database\Capsule\Manager as DB;

final class ListAction extends BaseRenderAction
{
	public function __construct(ContainerInterface $c, AssignmentRuleService $ruleService, TransactionService $transactionService)
    {
        parent::__construct($c);
        $this->ruleService = $ruleService;
        $this->transactionService = $transactionService;
    }

    public function renderContent($request, $args) {

        $params = $request->getQueryParams();

        //$category_id = $this->getQueryParam($request, 'category_id', null);
        //$category = $category_id ? Category::find($category_id) : null;
        //$month = $this->getQueryParam($request, 'month', null);

        $filter = $request->getAttribute('filter', $params->category_id ? 'categorized' : 'uncategorized');
        $match = $request->getAttribute('match', null);
        $sort = $this->getQueryParam($request, 'sort', 'date');
        
        $transactions = $this->getTransactionsFor($filter, $params, $sort);

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
            'own_accounts_count' => Transaction::whereIn('counter_account_iban', Account::pluck('iban'))->count(),
            'transactions' => $transactions,
            'categories' => CategoryTreeItem::where('id', '<>', $args['id'])->orderBy('breadcrump')->get(),
            'match' => $match
        ]);
    }

    protected function getTransactionsFor($filter, $params, $sort) {

        switch ($filter) {
            // all transactions with a category
            case 'categorized':
                $result = Transaction::whereNotNull('category_id');
                break;
            
            // transaction without a category, but not to own accounts
            case 'uncategorized':
                $result = Transaction::whereNull('category_id')->whereNotIn('counter_account_iban', Account::pluck('iban'));
                break;

            // transactions to own accounts
            case 'own-accounts':
                $result = Transaction::whereIn('counter_account_iban', Account::pluck('iban'));
                break;

            // should not be called
            default:
                $result = Transaction::all();
                break;
        }

        if ($params['category_id']) {
            $result = $result->where('category_id', $params['category_id']);
        }

        if ($params['month']) {
            $result = $result->where(DB::raw("strftime('%m-%Y', datetime(date, 'unixepoch', 'localtime'))"), '=', $params['month']);
        }

        if ($params['sign']) {
            $result = $result->where('sign', $params['sign']);
        }

        return $result->orderBy($sort)->get();
    }

    protected function match($transactions) {

        $matches = $this->ruleService->match($transactions, AssignmentRule::all());

        // TODO: Nice way
        $matchedTransactions = sizeof($matches);

        $this->flash->addMessageNow('success', sprintf('found %s matches', $matchedTransactions));

        return $matchedTransactions == 0 ? $transactions : $matches;
    }
}