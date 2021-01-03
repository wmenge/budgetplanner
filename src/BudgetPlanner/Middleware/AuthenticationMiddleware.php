<?php

namespace BudgetPlanner\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

use BudgetPlanner\Service\Oauth2Service;
use \BudgetPlanner\Model\User;

class AuthenticationMiddleware
{
    private $service;

    public function __construct(Oauth2Service $service) {
        $this->service = $service;
    }

    /**
     * Authentication middleware
     *
     * @param  ServerRequest  $request PSR-7 request
     * @param  RequestHandler $handler PSR-15 request handler
     *
     * @return Response
     */
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $response = $handler->handle($request);

        if (isset($_SESSION['access_token']) && $_SESSION['provider']) {
            $token = unserialize($_SESSION['access_token']);
            
            // Step 1: test validity of token
            if ($token->hasExpired()) {
                // TODO: Refresh token
                return $response->withHeader('Location', '/login')->withStatus(401);
            } else {
                $newAccessToken = $provider->getAccessToken('refresh_token', [
                    'refresh_token' => $token->getRefreshToken()
                ]);

                $_SESSION['access_token'] = serialize($newAccessToken);
            }

            // Step 2: test if token belongs to known user
            $providerName = $_SESSION['provider'];
            $provider = $this->service->getProvider($providerName);
            $ownerDetails = $provider->getResourceOwner($token);
            $userName = $ownerDetails->getEmail();

            $user = User::where('userName', $userName)->where('provider', $providerName)->first();

            if (!$user) {
                return $response->withHeader('Location', '/login')->withStatus(401);
            }

        } else {
            return $response->withHeader('Location', '/login')->withStatus(401);
        }

        return $response;
    }
}