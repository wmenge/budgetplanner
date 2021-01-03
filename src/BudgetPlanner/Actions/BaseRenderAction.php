<?php

namespace BudgetPlanner\Actions;

use Psr\Container\ContainerInterface;
use BudgetPlanner\Service\Oauth2Service;
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
    protected $oauthService;
    
    public function __construct(ContainerInterface $c) 
    {
        $this->renderer = $c->get(PhpRenderer::class);
        $this->flash = $c->get(Messages::class);
        $this->oauthService = $c->get(Oauth2Service::class);
    }

    public function __invoke(Request $request, Response $response, $args): ResponseInterface
    {
        return $this->renderPage($request, $response, $args);
    }

    protected function renderPage(Request $request, Response $response, $args): ResponseInterface
    {
        $ownerDetails = $this->oauthService->getOwnerDetails($this->oauthService->getToken());

        return $this->renderer->render($response, 'default-page.php', [
            'menu'    => $this->renderer->fetch('menu-fragment.php', []),
            'content' => $this->renderContent($request, $args),
            'flash' => $this->flash->getMessages(),
            'ownerDetails' => $ownerDetails
        ]);
    }

    protected abstract function renderContent($request, $args);

    protected function getQueryParam($request, $name, $default) {
        $params = $request->getQueryParams();
        return isset($params[$name]) ? $params[$name] : $default;

    }

}