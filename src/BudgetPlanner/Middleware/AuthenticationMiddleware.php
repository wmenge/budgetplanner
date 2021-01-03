<?php

namespace BudgetPlanner\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

class AuthenticationMiddleware
{
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

        //die();

        if (isset($_SESSION['access_token'])) {
            $token = unserialize($_SESSION['access_token']);

            print_r($token->hasExpired());

            // Step 1: test validity of token
            if ($token->hasExpired()) {
                // TODO: Refresh token
                return $response->withHeader('Location', '/login')->withStatus(401);
            }

            // Step 2: test if token belongs to known user

        } else {
            return $response->withHeader('Location', '/login')->withStatus(401);
        }



        return $response;
    }
}