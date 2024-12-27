<?php namespace BudgetPlanner\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CategoryTreeItem extends Model {

    protected $table = 'categories_tree';

	public function breadCrumpPath() {
        // breadcrumpobject is never supplied by user, but always calculated by database, so it should be save to evaluate
        return json_decode($this->breadcrumpobject);
    }

}