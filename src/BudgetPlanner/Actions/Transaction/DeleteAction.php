<?php

namespace BudgetPlanner\Actions\Transaction;

use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Response;
use Slim\Psr7\Request;
use Slim\Flash\Messages;
use \BudgetPlanner\Model\Transaction;

final class DeleteAction
{
	protected $flash;
    
    public function __construct(Messages $flash)
    {
        $this->flash = $flash;
    }

    public function __invoke(Request $request, Response $response, $args): ResponseInterface
    {
        Transaction::destroy($args['id']);

        $this->flash->addMessage('success', 'Deleted transaction');

        return $response->withHeader('Location', '/transactions')
                ->withStatus(303);
    }
}