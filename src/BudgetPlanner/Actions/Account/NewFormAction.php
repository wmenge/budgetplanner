<?php

namespace BudgetPlanner\Actions\Account;

use BudgetPlanner\Actions\BaseRenderAction;

final class NewFormAction extends BaseRenderAction
{
    public function renderContent($request, $args) {
        return $this->renderer->fetch('account-form-fragment.php', []);
    }
}