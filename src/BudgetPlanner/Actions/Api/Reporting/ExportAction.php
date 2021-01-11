<?php

namespace BudgetPlanner\Actions\Api\Reporting;

use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Response;
use Slim\Psr7\Request;

use \BudgetPlanner\Service\ExportService;

// move to api namespace
final class ExportAction
{
	public function __construct(ExportService $exportService)
    {
        $this->exportService = $exportService;
    }

    public function __invoke(Request $request, Response $response, $args): ResponseInterface
    {	
		$data = $this->exportService->export();
        $payload = json_encode($data, JSON_PRETTY_PRINT | JSON_NUMERIC_CHECK);
		$response->getBody()->write($payload);
		return $response->withHeader('Content-Type', 'application/json;charset=utf-8')
                       ->withHeader('Content-Disposition', 'attachment; filename=export-' . $_SERVER["HTTP_HOST"] . '-' . date('Y-m-d His') . '.json');
	}

	protected function getQueryParam($request, $name, $default) {
        $params = $request->getQueryParams();
        return isset($params[$name]) ? $params[$name] : $default;
    }
}