<?php

namespace BudgetPlanner\Actions\AssignmentRules;

use BudgetPlanner\Actions\BaseRenderAction;
use \BudgetPlanner\Model\Category;

final class ListAction extends BaseRenderAction
{
    public function renderContent($request, $args) {
        return $this->renderer->fetch('assignment-rules-list-fragment.php', [
            'category' => Category::find($args['category_id'])
        ]);
    }
}