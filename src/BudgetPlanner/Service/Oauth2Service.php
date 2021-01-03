<?php namespace BudgetPlanner\Service;

use Psr\Container\ContainerInterface;

class Oauth2Service {

    private $configurations;

    public function __construct(ContainerInterface $c) {
        $this->configurations = $c->get('settings')['oauth2'];
    }

    public function getProvider($name) {
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
}