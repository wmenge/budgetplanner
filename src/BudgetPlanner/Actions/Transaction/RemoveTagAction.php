<?php

namespace BudgetPlanner\Actions\Transaction;

use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Response;
use Slim\Psr7\Request;
use Slim\Flash\Messages;

use \BudgetPlanner\Model\Transaction;
use \BudgetPlanner\Model\Tag;

final class RemoveTagAction
{
	public function __construct(Messages $flash)
    {
        //$this->service = $service;
        $this->flash = $flash;
    }

    public function __invoke(Request $request, Response $response, $args): ResponseInterface
    {
        $transaction = Transaction::find($args['id']);
        $tag = Tag::find($args['tag_id']);

        $transaction->tags()->detach($tag);
        $transaction->save();

        $this->flash->addMessage('success', 'Removed tag');

        return $response->withHeader('Location', '/transactions/' . $args['id'])
                ->withStatus(303);
    }
}