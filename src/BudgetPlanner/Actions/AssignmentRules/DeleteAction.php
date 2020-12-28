<?php

namespace BudgetPlanner\Actions\AssignmentRules;

use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Response;
use Slim\Psr7\Request;
use Slim\Flash\Messages;
use \BudgetPlanner\Model\AssignmentRule;

final class DeleteAction
{
	protected $flash;
    
    public function __construct(Messages $flash)
    {
        $this->flash = $flash;
    }

    public function __invoke(Request $request, Response $response, $args): ResponseInterface
    {
        AssignmentRule::destroy($args['rule_id']);

        $this->flash->addMessage('success', 'Deleted assignment rule');

        return $response->withHeader('Location', '/categories/' . $args['category_id'])
                ->withStatus(303);
    }
}