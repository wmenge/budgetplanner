<?php

namespace BudgetPlanner\Actions\Category;

use BudgetPlanner\Actions\BaseRenderAction;
use \BudgetPlanner\Model\Category;

final class EditFormAction extends BaseRenderAction
{
    public function renderContent($request, $args) {
        return $this->renderer->fetch('category-form-fragment.php', [
            'category' => Category::find($args['id']),
            'categories' => Category::where('id', '<>', $args['id'])->get()
        ]);
    }
}