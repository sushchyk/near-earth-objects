<?php

namespace Neo\Presentation\Exception;

use Symfony\Component\HttpFoundation\Response;

class BadRequestException extends \Exception implements ApiException
{
    public function getHttpCode(): int
    {
        return Response::HTTP_BAD_REQUEST;
    }

    public function getUserMessage(): string
    {
        return $this->message;
    }
}
