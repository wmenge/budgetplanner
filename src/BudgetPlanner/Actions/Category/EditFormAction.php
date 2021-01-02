<?php

namespace BudgetPlanner\Actions\Category;

use BudgetPlanner\Actions\BaseRenderAction;
use \BudgetPlanner\Model\Category;
use \BudgetPlanner\Model\CategoryTreeItem;

final class EditFormAction extends BaseRenderAction
{
    public function renderContent($request, $args) {
        return $this->renderer->fetch('category-form-fragment.php', [
            'category' => Category::find($args['id']),
            'categories_tree' => CategoryTreeItem::where('id', '<>', $args['id'])->orderBy('breadcrump')->get()
        ]);
    }
}