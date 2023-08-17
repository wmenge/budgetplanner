<?php

namespace SimpleGTD\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

use SimpleGTD\Service\Oauth2Service;

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
        $token = $this->service->getOrRefreshToken();

        if (!$token) {
            return $response->withHeader('Location', '/login')->withStatus(401);
        }

        $user = $this->service->getAuthenticatedUser($token);  

        if (!$user) {
            return $response->withHeader('Location', '/login')->withStatus(401);
        }

        return $response;
    }
}