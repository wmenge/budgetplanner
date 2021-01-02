<?php

namespace BudgetPlanner\Actions\Tag;

use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Response;
use Slim\Psr7\Request;
use Slim\Flash\Messages;
use \BudgetPlanner\Model\Tag;

final class DeleteAction
{
	protected $flash;
    
    public function __construct(Messages $flash)
    {
        $this->flash = $flash;
    }

    public function __invoke(Request $request, Response $response, $args): ResponseInterface
    {
        Tag::destroy($args['id']);

        $this->flash->addMessage('success', 'Deleted tag');

        return $response->withHeader('Location', '/tags')
                ->withStatus(303);
    }
}