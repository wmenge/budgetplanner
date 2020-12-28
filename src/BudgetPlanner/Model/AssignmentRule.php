<?php namespace BudgetPlanner\Model;

use Illuminate\Database\Eloquent\Model;

class AssignmentRule extends Model {

	public function category()
    {
        return $this->belongsTo('BudgetPlanner\Model\Category');
    }
	
}