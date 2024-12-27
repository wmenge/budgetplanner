<?php

namespace BudgetPlanner\Actions\Tag;

use BudgetPlanner\Actions\BaseRenderAction;
use \BudgetPlanner\Model\Tag;
use \BudgetPlanner\Model\Category;

final class EditFormAction extends BaseRenderAction
{
    public function renderContent($request, $args) {
        return $this->renderer->fetch('tag-form-fragment.php', [
            'tag' => isset($args['id']) ? Tag::find($args['id']) : new Tag(),
            'categories' => Category::orderBy('description')->get(),
        ]);
    }
}