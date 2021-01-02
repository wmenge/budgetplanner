<?php

namespace BudgetPlanner\Actions\Tag;

use BudgetPlanner\Actions\BaseRenderAction;
use \BudgetPlanner\Model\Tag;

final class ListAction extends BaseRenderAction
{
    public function renderContent($request, $args) {
    	
        return $this->renderer->fetch('tag-list-fragment.php', [
            'tags' => Tag::orderBy('description')->get()
        ]);
    }
}