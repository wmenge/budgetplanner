<?php namespace BudgetPlanner\Model;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model {
	
    public function account()
    {
        return $this->belongsTo('BudgetPlanner\Model\Account');
    }

    public function counterAccount()
    {
        return $this->belongsTo('BudgetPlanner\Model\Account', 'counter_account_id');
    }

    public function category()
    {
        return $this->belongsTo('BudgetPlanner\Model\Category');
    }

}