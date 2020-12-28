<?php

namespace BudgetPlanner\Actions\Account;

use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Response;
use Slim\Psr7\Request;
use Slim\Flash\Messages;
use \BudgetPlanner\Model\Account;

final class DeleteAction
{
	protected $flash;
    
    public function __construct(Messages $flash)
    {
        $this->flash = $flash;
    }

    public function __invoke(Request $request, Response $response, $args): ResponseInterface
    {
        Account::destroy($args['id']);

        $this->flash->addMessage('success', 'Deleted account');

        return $response->withHeader('Location', '/accounts')
                ->withStatus(303);
    }
}