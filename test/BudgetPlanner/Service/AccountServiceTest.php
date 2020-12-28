<?php namespace BudgetPlanner\ServiceTest;

use PHPUnit\Framework\TestCase;
use \BudgetPlanner\Model\Account;
use BudgetPlanner\Service\AccountService;

class AccountServiceTest extends TestCase {

	protected $service;

	protected function setUp(): void {
		$this->service = new AccountService();
	}

	public function testMapData(): void {

		$data = [
			'iban' => 'Some IBAN', // todo: validate iban
			'description' => 'Some description',
			'holder' => 'Some holder'
		];

		$account = new Account();

		$this->service->map($data, $account);

		$this->assertEquals('Some IBAN', $account->iban);
		$this->assertEquals('Some description', $account->description);		
		$this->assertEquals('Some holder', $account->holder);
	}

}