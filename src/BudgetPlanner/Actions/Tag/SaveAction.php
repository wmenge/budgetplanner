<?php

namespace BudgetPlanner\Actions\Tag;

use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Response;
use Slim\Psr7\Request;
use Slim\Flash\Messages;

use \BudgetPlanner\Service\TagService;
use \BudgetPlanner\Model\Tag;

final class SaveAction
{
	public function __construct(TagService $service, Messages $flash)
    {
        $this->service = $service;
        $this->flash = $flash;
    }

    public function __invoke(Request $request, Response $response, $args): ResponseInterface
    {
        $data = $request->getParsedBody();

        $tag = ($data['id']) ? Tag::find($data['id']) : new Tag();
        $this->service->map($data, $tag);

        $tag->save();

        $this->flash->addMessage('success', sprintf('Saved tag "%s"', $tag->description));

        return $response->withHeader('Location', '/tags')
                ->withStatus(303);
    }
}