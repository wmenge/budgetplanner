<?php

namespace BudgetPlanner\Actions\Tag;

use BudgetPlanner\Actions\BaseRenderAction;
use \BudgetPlanner\Model\Tag;
use \BudgetPlanner\Model\Category;

final class NewFormAction extends BaseRenderAction
{
    public function renderContent($request, $args) {
        return $this->renderer->fetch('tag-form-fragment.php', [
            'tag' => new Tag(),
            'categories' => Category::orderBy('description')->get(),
        ]);
    }
}