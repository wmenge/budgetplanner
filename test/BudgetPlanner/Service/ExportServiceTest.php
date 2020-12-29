<?php namespace BudgetPlanner\Service;

use BudgetPlanner\Lib\DatabaseFacade;
use PHPUnit\Framework\TestCase;
use \BudgetPlanner\Model\Category;
use \BudgetPlanner\Model\Transaction;
use \BudgetPlanner\Model\Account;
use \BudgetPlanner\Model\AssignmentRule;
use BudgetPlanner\Service\ExportService;

class ExportServiceTest extends TestCase {

	protected $service;

	protected function setUp(): void {
		// todo: use unit test configuration
		$builder = new \DI\ContainerBuilder();
	        $builder->addDefinitions(__DIR__ . '/../../../config/container-test.php');
	        $this->another_container = $builder->build();
	    
        $dbFacade = $this->another_container->get(DatabaseFacade::class);
		$dbFacade->createDatabase();

		$this->service = $this->another_container->get(ExportService::class);
	}

	// TODO: Move to integratino test suite
	public function testExport(): void {

		$category1 = new Category();
		$category1->description = 'category 1';
		$category1->created_at = 0;
		$category1->updated_at = 0;
		$category1->save();

		$category2 = new Category();
		$category2->description = 'category 2';
		$category2->parent()->associate($category1);
		$category2->created_at = 0;
		$category2->updated_at = 0;
    	$category2->save();

    	$rule = new AssignmentRule();
        $rule->category()->associate($category2);
        $rule->field = 'description';
        $rule->pattern = 'Jumbo';
        $rule->created_at = 0;
		$rule->updated_at = 0;
        $rule->save();

        $account = new Account();
    	$account->iban = "some iban";
    	$account->description = 'Test account';
    	$account->created_at = 0;
		$account->updated_at = 0;
        $account->save();

    	$transaction = new Transaction();
    	$transaction->account()->associate($account);
        $transaction->category()->associate($category2);
    	$transaction->currency = 'EUR';
    	$transaction->sign = '+';
        $transaction->amount = 100;
        $transaction->balance_after_transaction = 100;
    	$transaction->sequence_id = 1;
    	$transaction->reference = '123';
    	$transaction->description = 'A description';
		$transaction->created_at = 0;
		$transaction->updated_at = 0;
    	$transaction->save();

		$payload = $this->service->export();

		print_r($payload);

		$expectedPayload = [
			'categories' => [
				[
					'id' => 1,
					'parent_id' => null,
					'description' => 'category 1'
				],
				[
					'id' => 2,
					'parent_id' => 1,
					'description' => 'category 2'
				]
			]
		];

		$this->assertEquals($expectedPayload, $payload);
	}

}