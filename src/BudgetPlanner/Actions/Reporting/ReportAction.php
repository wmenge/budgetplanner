<?php

namespace BudgetPlanner\Actions\Reporting;

use BudgetPlanner\Actions\BaseRenderAction;
use Illuminate\Database\Capsule\Manager as DB;

final class ReportAction extends BaseRenderAction
{
    public function renderContent($request, $args) {

    	$type = $request->getAttribute('type', 'periods');
    	$month = $request->getAttribute('month', '12-2020');
    	
    	$yearQuery = <<<QUERY
			select distinct strftime('%Y', datetime(date, 'unixepoch', 'localtime')) as period
			from transactions order by period
		QUERY;

    	$years = DB::select(DB::raw($yearQuery));

    	$monthsQuery = <<<QUERY
			select distinct strftime('%m-%Y', datetime(date, 'unixepoch', 'localtime')) as period
			from transactions order by period
		QUERY;

    	$months = DB::select(DB::raw($monthsQuery));

        return $this->renderer->fetch('report-fragment.php', [ 
        	'type' => $type,
        	'years' => $years,
        	'months' => $months,
        	'month' => $month ]);
    }
}