<?php

namespace BudgetPlanner\Actions\Oauth2;

use BudgetPlanner\Actions\BaseRenderAction;
use \BudgetPlanner\Model\Tag;
use \BudgetPlanner\Model\Category;

final class LoginFormAction extends BaseRenderAction
{
    public function renderContent($request, $args) {
        return $this->renderer->fetch('login-form-fragment.php', []);
    }
}