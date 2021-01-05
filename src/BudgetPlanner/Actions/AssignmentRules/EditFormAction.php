<?php

namespace BudgetPlanner\Actions\AssignmentRules;

use BudgetPlanner\Actions\BaseRenderAction;
use \BudgetPlanner\Model\Category;
use \BudgetPlanner\Model\AssignmentRule;

final class EditFormAction extends BaseRenderAction
{
    public function renderContent($request, $args) {
        return $this->renderer->fetch('assignment-rule-form-fragment.php', [
            'category' => Category::find($args['category_id']),
            'rule' => AssignmentRule::find($args['rule_id']),
            'categories' => Category::orderBy('description')->get(),
        ]);
    }
}