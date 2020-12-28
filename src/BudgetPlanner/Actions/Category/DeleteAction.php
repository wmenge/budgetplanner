<?php

namespace BudgetPlanner\Actions\Category;

use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Response;
use Slim\Psr7\Request;
use Slim\Flash\Messages;
use \BudgetPlanner\Model\Category;

final class DeleteAction
{
	protected $flash;
    
    public function __construct(Messages $flash)
    {
        $this->flash = $flash;
    }

    public function __invoke(Request $request, Response $response, $args): ResponseInterface
    {
        Category::destroy($args['id']);

        $this->flash->addMessage('success', 'Deleted category');

        return $response->withHeader('Location', '/categories')
                ->withStatus(303);
    }
}