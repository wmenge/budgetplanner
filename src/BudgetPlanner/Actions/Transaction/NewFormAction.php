<?php

namespace BudgetPlanner\Actions\Transaction;

use BudgetPlanner\Actions\BaseRenderAction;

use \BudgetPlanner\Model\Transaction;

final class NewFormAction extends BaseRenderAction
{
    public function renderContent($args) {
        return $this->renderer->fetch('transaction-form-fragment.php', [
            //'category' => Category::find($args['id']),
            //'categories' => Category::where('id', '<>', $args['id'])->get()
            //'categories' => Category::all()
        ]);
    }
}