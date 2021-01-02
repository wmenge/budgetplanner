<?php

namespace BudgetPlanner\Actions\Tag;

use BudgetPlanner\Actions\BaseRenderAction;
use \BudgetPlanner\Model\Tag;

final class NewFormAction extends BaseRenderAction
{
    public function renderContent($request, $args) {
        return $this->renderer->fetch('tag-form-fragment.php', []);
    }
}