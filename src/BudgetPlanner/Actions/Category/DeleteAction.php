<?php

namespace BudgetPlanner\Actions\Category;

use BudgetPlanner\Actions\BaseRenderAction;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Response;
use Slim\Psr7\Request;
use Slim\Views\PhpRenderer;
use \BudgetPlanner\Model\Category;

final class DeleteAction
{
    public function __invoke(Request $request, Response $response, $args): ResponseInterface
    {
        Category::destroy($args['id']);

        return $response->withHeader('Location', '/categories')
                ->withStatus(303);
    }
}