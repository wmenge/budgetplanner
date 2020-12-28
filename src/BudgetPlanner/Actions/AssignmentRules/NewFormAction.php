<?php

namespace BudgetPlanner\Actions\AssignmentRules;

use BudgetPlanner\Actions\BaseRenderAction;
use \BudgetPlanner\Model\Category;

final class NewFormAction extends BaseRenderAction
{
    public function renderContent($request, $args) {
        return $this->renderer->fetch('assignment-rule-form-fragment.php', [
        	'category' => Category::find($args['category_id'])
        ]);
    }
}