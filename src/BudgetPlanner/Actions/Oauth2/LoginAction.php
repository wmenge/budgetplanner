<?php

namespace BudgetPlanner\Actions\Oauth2;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Response;
use Slim\Psr7\Request;
use Slim\Flash\Messages;

final class LoginAction
{
    private $configurations;

    public function __construct(ContainerInterface $c) {
        $this->configurations = $c->get('settings')['oauth2'];
    }

    private function getProvider($name) {
        switch ($name) {
            case "github":
                return $this->getGitHubProvider($this->configurations[$name]);
                break;
            case "google":
                return $this->getGoogleProvider($this->configurations[$name]);
                break;
            default:
                exit('Oh dear...');
                break;
        }
    }

    private function getGitHubProvider($configuration) {
        return new \League\OAuth2\Client\Provider\Github($configuration);
    }

    private function getGoogleProvider($configuration) {
        return new \League\OAuth2\Client\Provider\Google($configuration);
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
            $provider = $this->getProvider($providerName);
            $authUrl = $provider->getAuthorizationUrl();
            $_SESSION['loginreferer'] = $referer;
            $_SESSION['oauth2state'] = $provider->getState();
            header('Location: '.$authUrl);
            exit;
        }
        //return "hlleo";
    }
}