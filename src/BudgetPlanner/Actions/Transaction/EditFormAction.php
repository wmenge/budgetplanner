<?php

namespace BudgetPlanner\Actions\Transaction;

use BudgetPlanner\Actions\BaseRenderAction;
use \BudgetPlanner\Model\Transaction;
use \BudgetPlanner\Model\Category;

final class EditFormAction extends BaseRenderAction
{
    public function renderContent($request, $args) {
        return $this->renderer->fetch('transaction-form-fragment.php', [
            'transaction' => Transaction::find($args['id']),
            'categories' => Category::orderBy('description')->get()
        ]);
    }
}