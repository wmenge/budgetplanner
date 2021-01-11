<?php

namespace BudgetPlanner\Actions\Transaction;

use BudgetPlanner\Actions\BaseRenderAction;
use \BudgetPlanner\Model\Transaction;

final class NewFormAction extends BaseRenderAction
{
    public function renderContent($request, $args) {
        return $this->renderer->fetch('transaction-form-fragment.php', []);
    }
}