<?php

declare(strict_types=1);


namespace Giftery\Exception;


use Exception;

class ChangeApiException extends Exception
{
    private string $path;
    /**
     * @var array<string,mixed>
     */
    private array $response;

    /**
     * @param string $path
     * @param array<string,mixed> $response
     * @return void
     */
    public static function raise(string $path, array $response): void
    {
        new self($path, $response);
    }

    /**
     * @param string $path
     * @param array<string,mixed> $response
     */
    public function __construct(string $path, array $response)
    {
        parent::__construct(sprintf('Change API exception for in path %s', $path));
        $this->path = $path;
        $this->response = $response;
    }

    public function path(): string
    {
        return $this->path;
    }

    /**
     * @return array<string,mixed>
     */
    public function response(): array
    {
        return $this->response;
    }
}