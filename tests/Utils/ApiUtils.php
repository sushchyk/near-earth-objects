<?php

namespace Neo\Tests\Utils;

use Symfony\Component\HttpFoundation\Response;

trait ApiUtils
{
    protected function apiRequest(string $method, string $uri, array $parameters = []): Response
    {
        $this->client->request($method, $uri , $parameters);

        return $this->client->getResponse();
    }

    protected function decodeResponse(Response $response): array
    {
        return json_decode((string)$response->getContent(), true, 512, JSON_THROW_ON_ERROR);
    }
}
