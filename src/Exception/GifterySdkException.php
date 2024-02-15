<?php

declare(strict_types=1);


namespace Giftery\Exception;


use Exception;

class GifterySdkException extends Exception
{
    /**
     * @var array<string,mixed>
     */
    private array $response;

    /**
     * @param string $message
     * @param array<string,mixed> $response
     */
    public function __construct(string $message, array $response)
    {
        parent::__construct($message);
        $this->response = $response;
    }

    /**
     * @return array<string,mixed>
     */
    public function response(): array
    {
        return $this->response;
    }
}