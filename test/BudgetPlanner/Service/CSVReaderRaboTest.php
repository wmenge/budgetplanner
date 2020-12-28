<?php namespace BudgetPlanner\Service;

use PHPUnit\Framework\TestCase;
use \BudgetPlanner\Service\CSVReaderRabo as CSVReaderRabo;

class CSVReaderRaboTest extends TestCase {

	public function testReadTransactions() {
		
		$reader = new CSVReaderRabo(dirname(__FILE__) . '/test1.csv');

		$reader->rewind();
		$this->assertEquals(true,$reader->valid());
		$current = $reader->current();

		$this->assertEquals([
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
			'sign' => '-',
			'amount' => 100,
			'balance_after_transaction' => 100,
			'description' => 'Some Description'
		], $current);

		$reader->next();
		$this->assertEquals(true,$reader->valid());
		$current = $reader->current();

		$this->assertEquals([
			'account' => [
				'iban' => 'BANK1234',
				'bic' => 'BANKBIC',
			],
			'counter_account_iban' => 'CONTRA1234',
			'counter_account_name' => 'Other Party',
			'currency' => 'EUR',
			'sequence_id' => 2,
			'date' => 1577923200,
			'interest_date' => 1577923200,
			'sign' => '+',
			'amount' => 50,
			'balance_after_transaction' => 150,
			'description' => 'Some Other Description'
		], $current);

		$reader->next();
		$this->assertEquals(false,$reader->valid());

	}

}