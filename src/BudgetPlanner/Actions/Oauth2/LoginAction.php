<?php

namespace BudgetPlanner\Actions\Oauth2;

use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Response;
use Slim\Psr7\Request;
use Slim\Flash\Messages;

use BudgetPlanner\Service\Oauth2Service;

final class LoginAction
{
    private $service;

    public function __construct(Oauth2Service $service) {
        $this->service = $service;
    }  

    public function __invoke(Request $request, Response $response, $args): ResponseInterface
    {
        $providerName = $args['provider'];
        $referer = $request->getQueryParams()['referer'];
        if (empty($referer)) $referer = '/';
        
        // TODO: If logging in with different provider, first log out
        if (isset($_SESSION['access_token'])) {
            $token = unserialize($_SESSION['access_token']);
            return $response->withHeader('Location', '/');
            //$this->loginWithAccessToken($providerName, $token, $referer);
        } else {
            // If we don't have an authorization code then get one
            $provider = $this->service->getProvider($providerName);
            $authUrl = $provider->getAuthorizationUrl();
            $_SESSION['loginreferer'] = $referer;
            $_SESSION['oauth2state'] = $provider->getState();
            header('Location: '.$authUrl);
            exit;
        }
        //return "hlleo";
    }
}