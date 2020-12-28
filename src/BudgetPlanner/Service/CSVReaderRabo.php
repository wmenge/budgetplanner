<?php namespace BudgetPlanner\Service;

class CSVReaderRabo extends AbstractCSVReader implements CSVIteratorInterface {

	function __construct($path) {
		parent::__construct($path);
		$this->fmt = new \NumberFormatter( 'nl_NL', \NumberFormatter::DECIMAL );
	}

	protected function readLine() {
		$csvLine = fgetcsv($this->resource);

		if (is_array($csvLine)) {

			$result =  [
				'account' => [
					'iban' => $csvLine[0],
					'bic' => $csvLine[2],
				],
				'counter_account_iban' => $csvLine[8],
				'counter_account_name' => $csvLine[9],
				'currency' => $csvLine[1],
				'sequence_id' => filter_var($csvLine[3], FILTER_SANITIZE_NUMBER_INT),
				'date' => strtotime($csvLine[4]),
				'interest_date' => strtotime($csvLine[5]),
				'sign' => substr($csvLine[6], 0, 1),
				'amount' => $this->fmt->parse(substr($csvLine[6], 1)),
				'balance_after_transaction' => $this->fmt->parse(str_replace('+', '', $csvLine[7])),
				'description' => $csvLine[19],
				//'contra_account' => $csvLine[8],
				//'counterparty_name' => $csvLine[9]
				/*'' => $csvLine[0],
				'' => $csvLine[0],
				'' => $csvLine[0],
				'' => $csvLine[0],*/
			];


			return $result;

		} else {
			return [];
		}
	}

	public function rewind() {
		parent::rewind();
		// Skip first line
		$this->next();
	}

}