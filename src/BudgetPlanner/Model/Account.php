<?php namespace BudgetPlanner\Model;

use Illuminate\Database\Eloquent\Model;

class Account extends Model {

	public function iban_formatted() {
		return !empty($this->iban) ? chunk_split($this->iban, 4, '&nbsp;') : null;
	}

	public function transactions()
    {
        return $this->hasMany('BudgetPlanner\Model\Transaction');
    }

    public function balance()
    {
        return $this->transactions()->orderBy('date', 'DESC')->first()->balance_after_transaction_formatted();
    }
	
}