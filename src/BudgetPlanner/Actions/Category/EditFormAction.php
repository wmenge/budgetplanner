<?php

namespace BudgetPlanner\Actions\Category;

use BudgetPlanner\Actions\BaseRenderAction;
use \BudgetPlanner\Model\Category;
use \BudgetPlanner\Model\CategoryTreeItem;

final class EditFormAction extends BaseRenderAction
{
    public function renderContent($request, $args) {
        return $this->renderer->fetch('category-form-fragment.php', [
            'detail' => isset($args['detail']) ?  $args['detail'] : 'rules',
            'category' => isset($args['id']) ?  Category::find($args['id']) : new Category(),
            'categories' => Category::orderBy('description')->get(),
            'categories_tree' => isset($args['id']) ? 
                CategoryTreeItem::where('id', '<>', $args['id'])->orderBy('breadcrump')->get() : 
                CategoryTreeItem::orderBy('breadcrump')->get()
        ]);
    }
}