<?php namespace BudgetPlanner\Service;

use BudgetPlanner\Lib\DatabaseFacade;
use PHPUnit\Framework\TestCase;
use \BudgetPlanner\Model\Transaction;
use \BudgetPlanner\Model\Account;
use BudgetPlanner\Service\TransactionService;

class TransactionServiceTest extends TestCase {

	//protected $transaction;
	protected $service;

	protected function setUp(): void {
		// todo: use unit test configuration
		$builder = new \DI\ContainerBuilder();
	        $builder->addDefinitions(__DIR__ . '/../../../config/container-test.php');
	        $this->another_container = $builder->build();
	    
        $dbFacade = $this->another_container->get(DatabaseFacade::class);
		$dbFacade->createDatabase();

		$this->service = $this->another_container->get(TransactionService::class);
	}

	// TODO: Move to integratino test suite
	public function testImportTransactions(): void {		
		$this->service->import(dirname(__FILE__) . '/test1.csv', 'r');
		$this->assertEquals(2, Transaction::all()->count());
		$this->assertEquals(1, Account::all()->count());
	}

	// TODO: Move to integratino test suite
	public function testIgnoreDuplicateTransactions(): void {		
		$this->service->import(dirname(__FILE__) . '/test1.csv', 'r');
		$this->assertEquals(2, Transaction::all()->count());
		$this->assertEquals(1, Account::all()->count());
	}

	public function testOwnAccount(): void {		
		$this->service->import(dirname(__FILE__) . '/test2.csv', 'r');

		$transaction = Transaction::find(1);
		$this->assertEquals(True, $this->service->ownAccount($transaction));
		
		$transaction = Transaction::find(2);
		$this->assertEquals(False, $this->service->ownAccount($transaction));
	}

	public function testMapData(): void {

		$data = [
			'account' => [
				'iban' => 'BANK1234',
				'bic' => 'BANKBIC',
			],
			'counter_account_iban' => 'CONTRA1234',
			'counter_account_name' => 'Other Party',
			'currency' => 'EUR',
			'sequence_id' => 1,
			'date' => 1577836800,
			'interest_date' => 1577836800,
			'amount' => 100,
			'balance_after_transaction' => 100,
			'contra_account' => 'CONTRA1234',
			'counterparty_name' => 'Other Party',
			'description' => 'Some Description'
		];

		$transaction = new Transaction();

		$this->service->map($data, $transaction);

		$this->assertEquals(1577836800, $transaction->date);
		$this->assertEquals(1577836800, $transaction->interest_date);
		$this->assertEquals(100, $transaction->balance_after_transaction);
		$this->assertEquals('EUR', $transaction->currency);
		$this->assertEquals(100, $transaction->amount);
		$this->assertEquals('Some Description', $transaction->description);

		/*$this->assertEquals([
			'account' => [
				'iban' => 'BANK1234',
				'bic' => 'BANKBIC',
			],
			'currency' => 'EUR',
			'sequence_id' => 1,
			'date' => 1577836800,
			'interest_date' => 1577836800,
			'amount' => 100,
			'balance_after_transaction' => 100,
			'contra_account' => 'CONTRA1234',
			'counterparty_name' => 'Other Party'
		], $this->transaction->as_array());*/

	}

}