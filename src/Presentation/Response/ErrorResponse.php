<?php

namespace Neo\Presentation\Response;

use Symfony\Component\HttpFoundation\JsonResponse;

class ErrorResponse extends JsonResponse
{
    public function __construct(mixed $data = null, int $status = 200, array $headers = [], bool $json = false)
    {
        $data = ['error' => $data];
        parent::__construct($data, $status, $headers, $json);
    }
}
