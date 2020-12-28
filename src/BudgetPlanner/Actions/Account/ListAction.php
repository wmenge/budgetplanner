<?php

namespace BudgetPlanner\Actions\Account;

use BudgetPlanner\Actions\BaseRenderAction;
use \BudgetPlanner\Model\Account;

final class ListAction extends BaseRenderAction
{
    public function renderContent($request, $args) {
        return $this->renderer->fetch('account-list-fragment.php', [
            'accounts' => Account::all()
        ]);
    }
}