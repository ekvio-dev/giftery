<?php

declare(strict_types=1);


namespace Giftery;


use Giftery\Request\HttpMethod;

interface HttpClient
{
    /**
     * @param HttpMethod $method
     * @param string $uri
     * @param array<string,string> $headers
     * @param string $body
     * @return string
     */
    public function request(HttpMethod $method, string $uri, array $headers, string $body): string;
}