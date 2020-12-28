<?php

namespace BudgetPlanner\Actions\Account;

use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Response;
use Slim\Psr7\Request;
use Slim\Flash\Messages;

use \BudgetPlanner\Service\AccountService;
use \BudgetPlanner\Model\Account;

final class SaveAction
{
	public function __construct(AccountService $service, Messages $flash)
    {
        $this->service = $service;
        $this->flash = $flash;
    }

    public function __invoke(Request $request, Response $response, $args): ResponseInterface
    {
        $data = $request->getParsedBody();

        // todo: autowire
        $account = ($data['id']) ? Account::find($data['id']) : new Account();
        $this->service->map($data, $account);
        
        $account->save();

        $this->flash->addMessage('success', sprintf('Saved account "%s"', $account->iban));

        return $response->withHeader('Location', '/accounts')
                ->withStatus(303);
    }
}