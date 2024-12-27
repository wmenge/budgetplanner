<?php

namespace BudgetPlanner\Actions\Account;

use BudgetPlanner\Actions\BaseRenderAction;
use \BudgetPlanner\Model\Account;

final class EditFormAction extends BaseRenderAction
{
    public function renderContent($request, $args) {
        return $this->renderer->fetch('account-form-fragment.php', [
            'account' => isset($args['id']) ? Account::find($args['id']) : new Account()
        ]);
    }
}