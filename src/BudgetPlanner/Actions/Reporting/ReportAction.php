<?php

namespace BudgetPlanner\Actions\Reporting;

use BudgetPlanner\Actions\BaseRenderAction;

final class ReportAction extends BaseRenderAction
{
    public function renderContent($request, $args) {
        return $this->renderer->fetch('report-fragment.php', []);
    }
}