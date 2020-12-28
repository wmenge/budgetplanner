<?php

namespace BudgetPlanner\Actions\AssignmentRules;

use BudgetPlanner\Actions\BaseRenderAction;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Response;
use Slim\Psr7\Request;

use \BudgetPlanner\Service\AssignmentRuleService;
use \BudgetPlanner\Model\AssignmentRule;

final class SaveAction
{
	public function __construct(AssignmentRuleService $service)
    {
        $this->service = $service;
    }

    public function __invoke(Request $request, Response $response, $args): ResponseInterface
    {
        $data = $request->getParsedBody();

        // todo: autowire
        $rule = ($data['id']) ? AssignmentRule::find($data['id']) : new AssignmentRule();

        $this->service->map($data, $rule);

        $rule->save();

        return $response->withHeader('Location', '/categories/' . $args['category_id'] . '/rules')
                ->withStatus(303);
    }
}