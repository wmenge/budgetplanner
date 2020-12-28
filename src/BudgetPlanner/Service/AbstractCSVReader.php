<?php namespace BudgetPlanner\Service;

// Assumes php autocloses the resource
abstract class AbstractCSVReader implements CSVIteratorInterface {

	protected $resource;
	protected $line;
	protected $current;
	protected $isValid;

	function __construct($path) {
		//echo(__FUNCTION__ . PHP_EOL);
		$this->resource = fopen($path, 'r');
		$this->line = 0;
	}
	
	public function current() {
		//echo(__FUNCTION__ . PHP_EOL);
		//print_r($this->current);
		return $this->current;
	}

	public function key() {
		//echo(__FUNCTION__ . PHP_EOL);
		///echo("key: " . $this->line . PHP_EOL);
		return $this->line;
	}

	public function next() {
		//echo(__FUNCTION__ . PHP_EOL);
		$this->internalValid();
		if ($this->valid()) {
			$this->current = $this->readLine();
			$this->line++;
			//echo("key: " . $this->line . PHP_EOL);
		}
	}

	public function rewind() {
		//echo(__FUNCTION__ . PHP_EOL);
		rewind($this->resource);
		$this->internalValid();
		$this->current = $this->readLine();
	}

	public function valid() {
		//echo(__FUNCTION__ . PHP_EOL);
		return $this->isValid;
	}

	protected abstract function readLine();

	private function internalValid() {
		//echo(__FUNCTION__ . PHP_EOL);
		$result = $this->resource && !feof($this->resource);
		//print_r("isvalid: " . $result . PHP_EOL);
		$this->isValid = $result;
	}

}