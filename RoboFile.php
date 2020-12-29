<?php declare(strict_types=1);

include './vendor/autoload.php';

use DI\Container;

use BudgetPlanner\Lib\DatabaseFacade as DatabaseFacade;
use \BudgetPlanner\Model\Account as Account;
use \BudgetPlanner\Model\Transaction as Transaction;
use \BudgetPlanner\Model\Category as Category;
use \BudgetPlanner\Model\AssignmentRule as AssignmentRule;


use \BudgetPlanner\Service\ExportService as ExportService;

/**
 * This is project's console commands configuration for Robo task runner.
 *
 * @see http://robo.li/
 */
class RoboFile extends \Robo\Tasks
{
    
    /**
     * The constructor.
     *
     * @param Connection $connection The database connection
     */
    public function __construct()
    {
        // robo brings along its own container from parent class, learn how 
        // to use that one
        $builder = new DI\ContainerBuilder();
        $builder->addDefinitions(__DIR__ . '/config/container.php');
        $this->another_container = $builder->build();
        $this->another_container->get('db');
    }

    // define public methods as commands

    public function setup() {
        $dbFacade = $this->another_container->get(DatabaseFacade::class);
		$dbFacade->createDatabase();
		echo 'Setup task has been performed' . PHP_EOL;
	}

	public function generateSampleData() {
		$this->setup();

    	$superCategory = new Category();
    	$superCategory->description = "Super category";
        $superCategory->save();

    	print_r($superCategory->getAttributes());

 		$category = new Category();
 		$category->parent()->associate($superCategory);
    	$category->description = "A category";
    	$category->save();

    	print_r($category->getAttributes());
    	print_r($category->parent()->first()->getAttributes());

        $rule = new AssignmentRule();
        $rule->category()->associate($category);
        $rule->field = 'description';
        $rule->pattern = 'Jumbo';
        $rule->save();

        print_r($rule->getAttributes());

    	$account = new Account();
    	$account->iban = "some iban";
    	$account->description = 'Test account';
        $account->save();

    	print_r($account->getAttributes());

    	$transaction = new Transaction();
    	$transaction->account()->associate($account);
        $transaction->category()->associate($category);
    	$transaction->currency = 'EUR';
        $transaction->amount = 100;
        $transaction->balance_after_transaction = 100;
    	$transaction->sequence_id = 1;
    	$transaction->reference = '123';
    	$transaction->description = 'A description';

    	$transaction->save();

    	print_r($transaction->getAttributes());
/*    	print_r($transaction->account()->find_one()->as_array());
        print_r($transaction->category()->find_one()->as_array());

        print_r($superCategory->children()->select_many()->find_array());
        print_r($superCategory->transactions()->select_many()->find_array());

        print_r($category->children()->select_many()->find_array());
        print_r($category->transactions()->select_many()->find_array());


        print_r(ORM::get_query_log());*/
	}

    public function export() {
        $service = $this->another_container->get(ExportService::class);
        print_r(json_encode($service->export(), JSON_PRETTY_PRINT | JSON_NUMERIC_CHECK));
    }

    public function import($path) {
        $content = file_get_contents($path);
        $data = json_decode($content, True);
        //print_r($data);

        $service = $this->another_container->get(ExportService::class);
        $service->import($data);
    }

}