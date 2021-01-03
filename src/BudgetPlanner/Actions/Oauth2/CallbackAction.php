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

        if (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {
            unset($_SESSION['oauth2state']);
            exit('Invalid state');
        } else {
            $provider = $this->service->getProvider($providerName);

            // Try to get an access token (using the authorization code grant)
            $token = $provider->getAccessToken('authorization_code', [
                'code' => $_GET['code']
            ]);

            $_SESSION['access_token'] = serialize($token);
            $_SESSION['provider'] = $providerName;
            $referer = $_SESSION['loginreferer'];
            unset($_SESSION['loginreferer']);

            return $response->withHeader('Location', '/');

            //$this->loginWithAccessToken($providerName, $token, $referer);
        }
    }
}