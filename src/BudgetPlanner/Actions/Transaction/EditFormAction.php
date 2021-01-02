<?php

namespace BudgetPlanner\Actions\Transaction;

use BudgetPlanner\Actions\BaseRenderAction;
use \BudgetPlanner\Model\Transaction;
use \BudgetPlanner\Model\Category;
use \BudgetPlanner\Model\Tag;

final class EditFormAction extends BaseRenderAction
{
    public function renderContent($request, $args) {
    	$transaction = Transaction::find($args['id']);

        return $this->renderer->fetch('transaction-form-fragment.php', [
            'transaction' => $transaction,
            'categories' => Category::orderBy('description')->get(),
            'tags' => Tag::whereNotIn('id', $transaction->tags->pluck('id'))->orderBy('description')->get()
        ]);
    }
}