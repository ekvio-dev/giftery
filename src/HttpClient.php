<?php

declare(strict_types=1);


namespace Giftery;


use Giftery\Request\Command;
use Giftery\Request\HttpMethod;

interface HttpClient
{
    /**
     * @param HttpMethod $method
     * @param Command $command
     * @param string $uri
     * @param array<string,string> $headers
     * @param string $body
     * @return string
     */
    public function request(HttpMethod $method, Command $command, string $uri, array $headers, string $body): string;
}