<?php

namespace BudgetPlanner\Actions\Transaction;

use BudgetPlanner\Actions\BaseRenderAction;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Response;
use Slim\Psr7\Request;
use Slim\Views\PhpRenderer;

use \BudgetPlanner\Model\Transaction;

final class DeleteAction
{
    public function __invoke(Request $request, Response $response, $args): ResponseInterface
    {
        Transaction::destroy($args['id']);

        return $response->withHeader('Location', '/transaction')
                ->withStatus(303);
    }
}