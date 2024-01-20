<?php

declare(strict_types=1);


namespace App\Exception;


use Exception;

class GifteryApiException extends Exception
{
    private int $apiCode;
    private string $apiMessage;
    /**
     * @var array<string,mixed>
     */
    private array $response;

    /**
     * @param int $code
     * @param string $message
     * @param array<string,mixed> $response
     */
    public function __construct(int $code, string $message, array $response)
    {
        parent::__construct('Call Giftery API error');
        $this->apiCode = $code;
        $this->apiMessage = $message;
        $this->response = $response;
    }

    public function code(): int
    {
        return $this->apiCode;
    }

    public function message(): string
    {
        return $this->apiMessage;
    }

    /**
     * @return array<string,mixed>
     */
    public function response(): array
    {
        return $this->response;
    }
}