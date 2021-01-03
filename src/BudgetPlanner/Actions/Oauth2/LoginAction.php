<?php

namespace BudgetPlanner\Actions\Oauth2;

use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Response;
use Slim\Psr7\Request;

use BudgetPlanner\Service\Oauth2Service;

final class LoginAction
{
    private $service;

    public function __construct(Oauth2Service $service) {
        $this->service = $service;
    }  

    public function __invoke(Request $request, Response $response, $args): ResponseInterface
    {
        $token = $this->service->getToken();

        if ($token) {
            return $response->withHeader('Location', '/');
        } else {
            $providerName = $args['provider'];
            $referer = $request->getQueryParams()['referer'];
            if (empty($referer)) $referer = '/';
            
            $authUrl = $this->service->setupAuthUrl($providerName, $referer);

            return $response->withHeader('Location', $authUrl);
        }
    }
}