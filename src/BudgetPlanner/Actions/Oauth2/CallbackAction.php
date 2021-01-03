<?php

namespace BudgetPlanner\Actions\Oauth2;

use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Response;
use Slim\Psr7\Request;
use Slim\Flash\Messages;

use BudgetPlanner\Service\Oauth2Service;

final class CallbackAction
{
    private $service;

    public function __construct(Oauth2Service $service) {
        $this->service = $service;
    }

    public function __invoke(Request $request, Response $response, $args): ResponseInterface
    {
        $providerName = $args['provider'];
        $oauthState = $_GET['state'];

        $this->service->retrieveNewToken($providerName, $oauthState);
        return $response->withHeader('Location', '/');
    }
}