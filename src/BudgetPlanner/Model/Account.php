<?php namespace BudgetPlanner\Model;

use Illuminate\Database\Eloquent\Model;

class Account extends Model {

	public function transactions()
    {
        return $this->hasMany('BudgetPlanner\Model\Transaction');
    }
	
}