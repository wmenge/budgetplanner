<?php 

namespace BudgetPlanner\Service;

use \BudgetPlanner\Model\Category;
use \BudgetPlanner\Model\AssignmentRule;
use \BudgetPlanner\Model\Account;
use \BudgetPlanner\Model\Transaction;

use \BudgetPlanner\Service\CategoryService;
use \BudgetPlanner\Service\AssignmentRuleService;
use \BudgetPlanner\Service\AccountService;
use \BudgetPlanner\Service\TransactionService;

class ExportService {

    protected $pdo;
    protected $categoryService;
    protected $assignmentRuleService;
    protected $accountService;
    protected $transactionService;
    
    public function __construct(\PDO $pdo, CategoryService $categoryService, AssignmentRuleService $assignmentRuleService, AccountService $accountService, TransactionService $transactionService)
    {
        $this->pdo = $pdo;
        $this->categoryService = $categoryService;
        $this->assignmentRuleService = $assignmentRuleService;
        $this->accountService = $accountService;
        $this->transactionService = $transactionService;
    }

    public function export() {
        // flat export, todo: json like nested export without unneeded keys
    	//$category = Category::with('rules')->get();
        //$accounts = Account::with('transactions')->get();

        return [
            'categories' => Category::all()->toArray(),
            'rules' => AssignmentRule::all()->toArray(),
            'accounts' => Account::all()->toArray(),
            'transactions' => Transaction::all()->toArray(),
        ];
    }

    public function import($data) {

        $this->pdo->beginTransaction();

        foreach ($data['categories'] as $record) {
            $object = Category::find($record['id']);
            if (!$object) $object = new Category();
            $this->categoryService->map($record, $object);
            $object->save();
        }

        foreach ($data['rules'] as $record) {
            $object = AssignmentRule::find($record['id']);
            if (!$object) $object = new AssignmentRule();
            $this->assignmentRuleService->map($record, $object);
            $object->save();
        }

        foreach ($data['accounts'] as $record) {
            $object = Account::find($record['id']);
            if (!$object) $object = new Account();
            $this->accountService->map($record, $object);
            $object->save();
        }

        foreach ($data['transactions'] as $record) {
            $object = Transaction::find($record['id']);
            if (!$object) $object = new Transaction();
            $this->transactionService->map($record, $object);
            $object->save();
        }

        $this->pdo->commit();
    }

}