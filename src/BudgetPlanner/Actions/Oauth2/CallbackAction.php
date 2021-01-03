<?php

namespace BudgetPlanner\Actions\Oauth2;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Response;
use Slim\Psr7\Request;
use Slim\Flash\Messages;

final class CallbackAction
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

        if (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {
            unset($_SESSION['oauth2state']);
            exit('Invalid state');
        } else {
            $provider = $this->getProvider($providerName);

            // Try to get an access token (using the authorization code grant)
            $token = $provider->getAccessToken('authorization_code', [
                'code' => $_GET['code']
            ]);

            $_SESSION['access_token'] = serialize($token);
            $referer = $_SESSION['loginreferer'];
            unset($_SESSION['loginreferer']);

            return $response->withHeader('Location', '/');

            //$this->loginWithAccessToken($providerName, $token, $referer);
        }
    }
}