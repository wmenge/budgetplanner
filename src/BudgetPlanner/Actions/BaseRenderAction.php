<?php

namespace BudgetPlanner\Actions;

use BudgetPlanner\Actions\BaseRenderAction;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Response;
use Slim\Psr7\Request;
use Slim\Views\PhpRenderer;
use Slim\Flash\Messages;

abstract class BaseRenderAction
{
    /**
     * @var Responder
     */
    protected $renderer;
    protected $flash;
    
    public function __construct(PhpRenderer $renderer, Messages $flash)
    {
        $this->renderer = $renderer;
        $this->flash = $flash;
    }

    public function __invoke(Request $request, Response $response, $args): ResponseInterface
    {
        return $this->renderPage($request, $response, $args);
    }

    protected function renderPage(Request $request, Response $response, $args): ResponseInterface
    {
        //$this->flash->addMessageNow('success', 'This is a message');

        return $this->renderer->render($response, 'default-page.php', [
            'menu'    => $this->renderer->fetch('menu-fragment.php'),
            'content' => $this->renderContent($request, $args),
            'flash' => $this->flash->getMessages()
        ]);
    }

    protected abstract function renderContent($request, $args);

}