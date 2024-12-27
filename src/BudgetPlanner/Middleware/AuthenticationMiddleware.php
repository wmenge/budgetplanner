<?php

namespace BudgetPlanner\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

use Slim\Factory\AppFactory;

use BudgetPlanner\Service\Oauth2Service;

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
        $token = $this->service->getOrRefreshToken();

        if (!$token) {
            // TODO instead of creating, get from index.php where it is created
            $app = AppFactory::create();
            $response = $app->getResponseFactory()->createResponse();
            $response->getBody()->write('Unauthorized');
            return $response->withHeader('Location', '/login')->withStatus(302);
        }

        $user = $this->service->getAuthenticatedUser($token);  

        if (!is_object($user)) {
            // TODO instead of creating, get from index.php where it is created
            $app = AppFactory::create();
            $response = $app->getResponseFactory()->createResponse();
            $response->getBody()->write('Unauthorized');
            return $response->withHeader('Location', '/login')->withStatus(302);
        }

        return $handler->handle($request);

        $token = $this->service->getOrRefreshToken();

        // if (!$token) {
            
        //     //$response->getBody()->write('Unauthorized');
        //     //return $response->withHeader('Location', '/login')->withStatus(401);
        //     return $response->withStatus(401);
        // }

        // $user = $this->service->getAuthenticatedUser($token);  

        // if (!is_object($user)) {
        //     //$response->getBody()->write('Unauthorized');
        //     //return $response->withHeader('Location', '/login')->withStatus(401);
        //     return $response->withStatus(401);d
        // }

        // return $handler->handle($request);
    }
}