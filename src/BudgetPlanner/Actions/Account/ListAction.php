<?php

namespace BudgetPlanner\Actions\Account;

use BudgetPlanner\Actions\BaseRenderAction;
use \BudgetPlanner\Model\Account;

final class ListAction extends BaseRenderAction
{
    public function renderContent($request, $args) {
    	$sort = $this->getQueryParam($request, 'sort', 'iban');

        return $this->renderer->fetch('account-list-fragment.php', [
            'accounts' => Account::orderBy($sort)->get()
        ]);
    }
}