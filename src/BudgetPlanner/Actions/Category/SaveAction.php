<?php

namespace BudgetPlanner\Actions\Category;

use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Response;
use Slim\Psr7\Request;
use Slim\Flash\Messages;

use \BudgetPlanner\Service\CategoryService;
use \BudgetPlanner\Model\Category;

final class SaveAction
{
	public function __construct(CategoryService $service, Messages $flash)
    {
        $this->service = $service;
        $this->flash = $flash;
    }

    public function __invoke(Request $request, Response $response, $args): ResponseInterface
    {
        $data = $request->getParsedBody();

        // todo: autowire
        $category = ($data['id']) ? Category::find($data['id']) : new Category();
        $this->service->map($data, $category);
        
        $category->save();

        $this->flash->addMessage('success', sprintf('Saved category "%s"', $category->description));

        return $response->withHeader('Location', '/categories')
                ->withStatus(303);
    }
}