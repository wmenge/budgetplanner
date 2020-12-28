<?php namespace BudgetPlanner\ServiceTest;

use BudgetPlanner\Lib\DatabaseFacade;
use PHPUnit\Framework\TestCase;
use \BudgetPlanner\Model\Category;
use \BudgetPlanner\Model\Transaction;
use \BudgetPlanner\Model\AssignmentRule;
use BudgetPlanner\Service\AssignmentRuleService;
use BudgetPlanner\Service\TransactionService;

class AssignmentRuleServiceTest extends TestCase {

	protected $assignmentRuleService;
	protected $transactionService;

	protected function setUp(): void {
		// todo: use unit test configuration
		$builder = new \DI\ContainerBuilder();
	        $builder->addDefinitions(__DIR__ . '/../../../config/container.php');
	        $this->another_container = $builder->build();
	    
        $dbFacade = $this->another_container->get(DatabaseFacade::class);
		$dbFacade->createDatabase();

		$this->assignmentRuleService = new AssignmentRuleService();
		$this->transactionService = $this->another_container->get(TransactionService::class);
	}

	public function testMapData(): void {

		$data = [
			'category_id' => '1', // todo: validate category
			'field' => 'field',
			'pattern' => 'pattern'
		];

		$rule = new AssignmentRule();

		$this->assignmentRuleService->map($data, $rule);

		$this->assertEquals(1, $rule->category_id);
		c$this->assertEquals('field', $rule->field);
		$this->assertEquals('pattern', $rule->pattern);
	}

	public function testAssignCategories() {

		$this->transactionService->import(dirname(__FILE__) . '/test1.csv', 'r');
		//print(Account::all());
		//print(Transaction::all());

		// Setup a Category and Assignment Rule
		$category = new Category();
 		$category->description = "A category";
    	$category->save();

    	//print_r($category->getAttributes());
    	
        $rule = new AssignmentRule();
        $rule->category()->associate($category);
        $rule->field = 'description';
        $rule->pattern = 'Other';
        $rule->save();

        $matches = $this->assignmentRuleService->match(Transaction::all(), AssignmentRule::all());

        print_r($matches[0]->category);

        $this->assertEquals(null, $matches[0]->category);
        $this->assertEquals($category->id, $matches[1]->category->id);

	}

}