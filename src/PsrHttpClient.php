<?php

declare(strict_types=1);


namespace Giftery;


use Giftery\Exception\HttpException;
use Giftery\Request\Command;
use Giftery\Request\HttpMethod;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;

class PsrHttpClient implements HttpClient
{
    private RequestFactoryInterface&StreamFactoryInterface $httpFactory;
    private ClientInterface $client;

    public function __construct(RequestFactoryInterface&StreamFactoryInterface $httpFactory, ClientInterface $client)
    {
        $this->httpFactory = $httpFactory;
        $this->client = $client;
    }
    public function request(HttpMethod $method, Command $command, string $uri, array $headers, string $body): string
    {
        $request = $this->httpFactory->createRequest($method->value, $uri);
        $request = $this->addHeaders($request, $headers);

        if ($method->isPost()) {
            $request = $request->withBody(
                $this->httpFactory->createStream($body)
            );
        }

        $response = $this->client->sendRequest($request);
        $this->guardResponse($response);

        return (string) $response->getBody();
    }

    private function guardResponse(ResponseInterface $response): void
    {
        if ($response->getStatusCode() >= 400) {
            throw new HttpException($response->getStatusCode(), $response->getReasonPhrase());
        }
    }

    /**
     * @param RequestInterface $request
     * @param array<string,string> $headers
     * @return RequestInterface
     */
    private function addHeaders(RequestInterface $request, array $headers): RequestInterface
    {
        if (!$headers) {
            return $request;
        }

        foreach ($headers as $name => $value) {
            $request = $request->withHeader($name, $value);
        }

        return $request;
    }
}