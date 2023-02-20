<?php

namespace Neo\Presentation\Exception;

interface ApiException
{
    public function getHttpCode(): int;

    public function getUserMessage(): string;
}
