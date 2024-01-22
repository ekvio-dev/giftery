<?php

declare(strict_types=1);


namespace Giftery\Exception;


use Exception;

class HttpException extends Exception
{
    private int $httpCode;
    private string $httpPhrase;
    public function __construct(int $code, string $phrase)
    {
        parent::__construct('Http exception');
        $this->httpCode = $code;
        $this->httpPhrase = $phrase;
    }

    public function code(): int
    {
        return $this->httpCode;
    }

    public function phrase(): string
    {
        return $this->httpPhrase;
    }
}