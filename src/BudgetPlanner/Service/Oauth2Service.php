<?php namespace BudgetPlanner\Service;

use Psr\Container\ContainerInterface;
use \BudgetPlanner\Model\User;
use League\OAuth2\Client\Grant\RefreshToken;

class Oauth2Service {

    private $configurations;

    public function __construct(ContainerInterface $c) {
        $this->configurations = $c->get('settings')['oauth2'];
    }

    public function getToken() {
        if (isset($_SESSION['access_token'])) {
            return unserialize($_SESSION['access_token']);
        }
    }

    public function getOrRefreshToken() {
        $token = $this->getToken();

        if ($token && $token->hasExpired()) {
            $token = $this->RefreshToken($token);
        }

        return $token;
    }

    public function setupAuthUrl($providerName, $referer) {
        $provider = $this->getProvider($providerName);
        $authUrl = $provider->getAuthorizationUrl();
        $_SESSION['loginreferer'] = $referer;
        $_SESSION['oauth2state'] = $provider->getState();
        return $authUrl;
    }

    public function retrieveNewToken($providerName, $oauthState) {

        if (empty($oauthState) || ($oauthState !== $_SESSION['oauth2state'])) {
            unset($_SESSION['oauth2state']);
            exit('Invalid state');
        } else {
            $provider = $this->getProvider($providerName);

            // Try to get an access token (using the authorization code grant)
            $token = $provider->getAccessToken('authorization_code', [
                'code' => $_GET['code']
            ]);

            $_SESSION['access_token'] = serialize($token);
            $_SESSION['provider'] = $providerName;
            unset($_SESSION['loginreferer']);

            return $token;
        }
    }

    public function refreshToken($token) {

        if (!isset($_SESSION['provider'])) return null;
        
        $providerName = $_SESSION['provider'];
        $provider = $this->getProvider($providerName);

        $grant = new RefreshToken();
        $refreshToken = $token->getRefreshToken();

        if (!$refreshToken) {
            return null;
        }

        $newAccessToken = $provider->getAccessToken('refresh_token', [
            'refresh_token' => $refreshToken
        ]);

        $_SESSION['access_token'] = serialize($newAccessToken);

        return getToken();
    }

    public function getAuthenticatedUser($token) {
        if (!isset($_SESSION['provider'])) return null;

        $providerName = $_SESSION['provider'];
        $ownerDetails = $this->getOwnerDetails($token);

        $userName = $ownerDetails->getEmail();
        
        return User::where('userName', $userName)->where('provider', $providerName)->first();
    }

    public function getOwnerDetails($token) {
        if (!$token) return null;
        if (!isset($_SESSION['provider'])) return null;

        $providerName = $_SESSION['provider'];
        $provider = $this->getProvider($providerName);
        return $provider->getResourceOwner($token);
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
}