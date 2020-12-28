<?php

namespace BudgetPlanner\Actions\Transaction;

use BudgetPlanner\Actions\BaseRenderAction;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Response;
use Slim\Psr7\Request;
use Slim\Views\PhpRenderer;

use \BudgetPlanner\Service\TransactionService;
use \BudgetPlanner\Model\Transaction;

final class SaveAction
{
	public function __construct(TransactionService $service)
    {
        $this->service = $service;
    }

    public function __invoke(Request $request, Response $response, $args): ResponseInterface
    {
        $data = $request->getParsedBody();

        // todo: autowire
        $transaction = ($data['id']) ? Transaction::find($data['id']) : new Transaction();
        $this->service->map($data, $transaction);

        $transaction->save();

        return $response->withHeader('Location', '/transactions')
                ->withStatus(303);
    }
}