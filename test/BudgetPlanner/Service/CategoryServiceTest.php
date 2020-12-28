<?php namespace BudgetPlanner\ServiceTest;

use PHPUnit\Framework\TestCase;
use \BudgetPlanner\Model\Category;
use BudgetPlanner\Service\CategoryService;

class CategoryServiceTest extends TestCase {

	protected $service;

	protected function setUp(): void {
		$this->service = new CategoryService();
	}

	public function testMapData(): void {

		$data = [
			'description' => 'Some description',
			'parent_id' => 'Some id'
		];

		$category = new Category();

		$this->service->map($data, $category);

		$this->assertEquals('Some description', $category->description);
		$this->assertEquals('Some id', $category->parent_id);
	}

}