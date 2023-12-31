<?php namespace BudgetPlanner\Service;

use BudgetPlanner\Lib\DatabaseFacade;
use PHPUnit\Framework\TestCase;
use \BudgetPlanner\Model\Category;
use \BudgetPlanner\Model\Transaction;
use \BudgetPlanner\Model\Account;
use \BudgetPlanner\Model\AssignmentRule;
use \BudgetPlanner\Model\Tag;
use \BudgetPlanner\Model\User;
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

		$user = new User();
        $user->userName = 'some user';
        $user->provider = 'some provider';
        $user->created_at = 0;
		$user->updated_at = 0;
        $user->save();

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
    	$transaction->additional_description = 'Another description';
		$transaction->created_at = 0;
		$transaction->updated_at = 0;
    	$transaction->save();

    	$tag = new Tag();
    	$tag->description = 'Some tag';
    	$tag->created_at = 0;
		$tag->updated_at = 0;
		$tag->save();
		$tag->transactions()->attach($transaction);

		$payload = $this->service->export();

		$expectedPayload = [
			'users' => [
				[
					'id' => 1,
	                'userName' => 'some user',
	                'provider' => 'some provider',
	                'created_at' => '1970-01-01T00:00:00.000000Z',
	                'updated_at' => '1970-01-01T00:00:00.000000Z'
                ]
            ],
			'categories' => [
				[
					'id' => 1,
					'parent_id' => null,
					'description' => 'category 1',
					'created_at' => '1970-01-01T00:00:00.000000Z',
					'updated_at' => '1970-01-01T00:00:00.000000Z'
				],
				[
					'id' => 2,
					'parent_id' => 1,
					'description' => 'category 2',
					'created_at' => '1970-01-01T00:00:00.000000Z',
					'updated_at' => '1970-01-01T00:00:00.000000Z'
				]
			],
			'rules' => [
				[
					'id' => 1,
	                'category_id' => 2,
	                'field' => 'description',
	                'pattern' => 'Jumbo',
	                'created_at' => '1970-01-01T00:00:00.000000Z',
	                'updated_at' => '1970-01-01T00:00:00.000000Z'
                ]
            ],
    		'accounts' => [
		    	[
			        'id' => 1,
			        'iban' => 'some iban',
			        'description' => 'Test account',
			        'holder' => '',
			        'created_at' => '1970-01-01T00:00:00.000000Z',
			        'updated_at' => '1970-01-01T00:00:00.000000Z'
				]
			],
			'transactions' => [
				[
					'id' => 1,
                    'category_id' => '2',
                    'account_id' => '1',
                    'counter_account_iban' => null,
                    'counter_account_name' => null,
                    'sequence_id' => '1',
                    'date' => '0',
                    'interest_date' => '0',
                    'sign' => '+',
                    'amount' => '100',
                    'balance_after_transaction' => '100',
                    'currency' => 'EUR',
                    'reference' => '123',
                    'description' => 'A description',
                    'additional_description' => 'Another description',
                    'created_at' => '1970-01-01T00:00:00.000000Z',
                    'updated_at' => '1970-01-01T00:00:00.000000Z'
				]
			],
			'tags' => [
		        [
		            "id" => 1,
		            "description" => "Some tag",
		            "created_at" => '1970-01-01T00:00:00.000000Z',
		            "updated_at" => '1970-01-01T00:00:00.000000Z'
		        ]
		    ],
		    "tag_transaction" => [
		        [
		            "tag_id" => '1',
		            "transaction_id" => '1',
		            "created_at" => '0',
		            "updated_at" => '0'
		        ]
	    	]
		];

		$this->assertEquals($expectedPayload, $payload);
	}

}