<?php namespace BudgetPlanner\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CategoryTreeItem extends Model {

    protected $table = 'categories_tree';

	/*public function parent()
    {
        return $this->belongsTo('BudgetPlanner\Model\Category', 'parent_id');
    }

	public function children()
    {
        return $this->hasMany('BudgetPlanner\Model\Category', 'parent_id');
    }

    public function transactions()
    {
        return $this->hasMany('BudgetPlanner\Model\Transaction');
    }

    public function rules()
    {
        return $this->hasMany('BudgetPlanner\Model\AssignmentRule');
    }*/

}