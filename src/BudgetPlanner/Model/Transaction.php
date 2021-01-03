<?php namespace BudgetPlanner\Model;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model {

    private static $fmt;

    public function counter_account_iban_formatted() {
        return !empty($this->counter_account_iban) ? chunk_split($this->counter_account_iban, 4, '&nbsp;') : null;
    }

    public function amount_formatted() {
        if (!$this->fmt) $this->fmt = \NumberFormatter::create( 'nl_NL', \NumberFormatter::CURRENCY );
        return $this->fmt->formatCurrency($this->amount, $this->currency);
    }
	
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

    public function tags()
    {
        return $this->belongsToMany('BudgetPlanner\Model\Tag');
    }

}