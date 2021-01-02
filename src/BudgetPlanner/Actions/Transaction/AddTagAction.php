<?php

namespace BudgetPlanner\Actions\Transaction;

use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Response;
use Slim\Psr7\Request;
use Slim\Flash\Messages;

use \BudgetPlanner\Model\Transaction;
use \BudgetPlanner\Model\Tag;

final class AddTagAction
{
	public function __construct(Messages $flash)
    {
        //$this->service = $service;
        $this->flash = $flash;
    }

    public function __invoke(Request $request, Response $response, $args): ResponseInterface
    {
        $data = $request->getParsedBody();
        
        $transaction = Transaction::find($args['id']);
        $tag = Tag::find($data['tag_id']);

        $transaction->tags()->attach($tag);
        $transaction->save();

        $this->flash->addMessage('success', 'Added tag');

        return $response->withHeader('Location', '/transactions/' . $args['id'])
                ->withStatus(303);
    }
}