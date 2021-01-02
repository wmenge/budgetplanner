<?php namespace BudgetPlanner\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tag extends Model {

    public function transactions()
    {
        return $this->belongsToMany('BudgetPlanner\Model\Transaction');
    }

}