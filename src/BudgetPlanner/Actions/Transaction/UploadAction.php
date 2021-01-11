<?php

namespace BudgetPlanner\Actions\Transaction;

use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Response;
use Slim\Psr7\Request;
use Slim\Views\PhpRenderer;

use \BudgetPlanner\Service\TransactionService;
use \BudgetPlanner\Model\Transaction;

final class UploadAction
{
    public function __construct(TransactionService $service)
    {
        $this->service = $service;
    }

    public function __invoke(Request $request, Response $response, $args): ResponseInterface
    {
        $uploadedFiles = $request->getUploadedFiles();
        $uploadedFile = $uploadedFiles['transactionFile'];
        $this->service->import($uploadedFile->getFilePath());
        return $response->withHeader('Location', '/transactions')->withStatus(303);
    }

    function getResource($request) {
        if ($request->getBody()->getSize() > 0) {

           $resource = $request->getBody()->detach();
        
        } elseif ($_FILES['transactionFile']['error'] == UPLOAD_ERR_OK               //checks for errors
                && is_uploaded_file($_FILES['transactionFile']['tmp_name'])) {
              
            $resource = fopen($_FILES['transactionFile']['tmp_name'], 'r');
        }
    }
}