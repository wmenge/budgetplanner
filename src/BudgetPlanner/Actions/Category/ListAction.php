<?php

namespace BudgetPlanner\Actions\Category;

use BudgetPlanner\Actions\BaseRenderAction;
use \BudgetPlanner\Model\Category;

final class ListAction extends BaseRenderAction
{
    public function renderContent($request, $args) {
    	
        return $this->renderer->fetch('category-list-fragment.php', [
            'categories' => Category::all()
        ]);
    }
}