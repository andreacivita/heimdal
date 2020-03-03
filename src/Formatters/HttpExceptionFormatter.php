<?php

namespace Andreacivita\Heimdal\Formatters;

use Exception;
use Illuminate\Http\JsonResponse;
use Andreacivita\Heimdal\Formatters\ExceptionFormatter;

class HttpExceptionFormatter extends ExceptionFormatter
{
    public function format(JsonResponse $response, Exception $e, array $reporterResponses)
    {
        parent::format($response, $e, $reporterResponses);
        
        if (count($headers = $e->getHeaders())) {
            $response->headers->add($headers);
        }

        $response->setStatusCode($e->getStatusCode());
    }
}
