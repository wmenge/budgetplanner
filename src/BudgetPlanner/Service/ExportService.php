<?php 

namespace BudgetPlanner\Service;

use Illuminate\Database\Capsule\Manager as DB;

use \BudgetPlanner\Model\Category;
use \BudgetPlanner\Model\AssignmentRule;
use \BudgetPlanner\Model\Account;
use \BudgetPlanner\Model\Transaction;
use \BudgetPlanner\Model\Tag;
use \BudgetPlanner\Model\User;

use \BudgetPlanner\Service\CategoryService;
use \BudgetPlanner\Service\AssignmentRuleService;
use \BudgetPlanner\Service\AccountService;
use \BudgetPlanner\Service\TransactionService;
use \BudgetPlanner\Service\TagService;

class ExportService {

    protected $pdo;
    protected $categoryService;
    protected $assignmentRuleService;
    protected $accountService;
    protected $transactionService;
    protected $tagService;
    
    public function __construct(\PDO $pdo, CategoryService $categoryService, AssignmentRuleService $assignmentRuleService, AccountService $accountService, TransactionService $transactionService, TagService $tagService)
    {
        $this->pdo = $pdo;
        $this->categoryService = $categoryService;
        $this->assignmentRuleService = $assignmentRuleService;
        $this->accountService = $accountService;
        $this->transactionService = $transactionService;
        $this->tagService = $tagService;
    }

    public function export() {
       // print_r(User::all()->toArray());


//print_r(array_map(function ($value) { return (array)$value; }, DB::table('tag_transaction')->get()->toArray()));

        //print_r(DB::table('tag_transaction')->get()->toArray());
        // flat export, todo: json like nested export without unneeded keys
    	return [
            'users' => User::all()->toArray(),
            'categories' => Category::all()->toArray(),
            'rules' => AssignmentRule::all()->toArray(),
            'tags' => Tag::all()->toArray(),
            'accounts' => Account::all()->toArray(),
            'transactions' => Transaction::all()->toArray(),
            'tags' => Tag::all()->toArray(),
            'tag_transaction' => array_map(function ($value) { return (array)$value; }, DB::table('tag_transaction')->get()->toArray())
        ];
    }

    public function import($data) {

        $this->pdo->beginTransaction();

        foreach ($data['users'] as $record) {
            $object = User::find($record['id']);
            if (!$object) $object = new User();
            $object->userName = $record['userName'];
            $object->provider = $record['provider'];
            $object->save();
        }

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

        foreach ($data['tags'] as $record) {
            $object = Tag::find($record['id']);
            if (!$object) $object = new Tag();
            $this->tagService->map($record, $object);
            $object->save();
        }

        foreach ($data['tag_transaction'] as $record) {
            $tag = Tag::find($record['tag_id']);
            $transaction = Transaction::find($record['transaction_id']);
            if ($tag && $transaction) {
                $transaction->tags()->attach($tag);
                $transaction->save();                
            }
        }

        $this->pdo->commit();
    }

}