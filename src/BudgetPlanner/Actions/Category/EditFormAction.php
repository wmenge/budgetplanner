<?php

namespace BudgetPlanner\Actions\Category;

use BudgetPlanner\Actions\BaseRenderAction;
use \BudgetPlanner\Model\Category;
use \BudgetPlanner\Model\CategoryTreeItem;

final class EditFormAction extends BaseRenderAction
{
    public function renderContent($request, $args) {
        $parent = isset($args['parent']) ? Category::find($args['parent']) : null;
        $category = isset($args['id']) ?  Category::find($args['id']) : new Category();

        if (!isset($category->parent_id) && isset($parent->id)) $category->parent_id = $parent->id;

        return $this->renderer->fetch('category-form-fragment.php', [
            'detail' => isset($args['detail']) ?  $args['detail'] : 'transactions',
            'category' => $category,
            'categories' => Category::orderBy('description')->get(),
            'categories_tree' => isset($args['id']) ? 
                CategoryTreeItem::where('id', '<>', $args['id'])->orderBy('breadcrump')->get() : 
                CategoryTreeItem::orderBy('breadcrump')->get()
        ]);
    }
}