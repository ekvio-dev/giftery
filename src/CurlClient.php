<?php

declare(strict_types=1);


namespace Giftery;


use CurlHandle;
use Giftery\Exception\HttpException;
use Giftery\Request\HttpMethod;
use InvalidArgumentException;

class CurlClient implements HttpClient
{
    private CurlHandle $curlHandle;
    /**
     * @var array<int,mixed>
     */
    private array $options;

    /**
     * @param array<int,mixed> $options
     */
    public function __construct(array $options = [])
    {
        $ch = curl_init();
        if (!$ch instanceof CurlHandle) {
            throw new InvalidArgumentException('Cannot instantiate (curl_init()) curl handler');
        }
        $this->curlHandle = $ch;
        $this->options = $options;
    }
    public function request(HttpMethod $method, string $uri, array $headers, string $body): string
    {
        $headers = $this->prepareHeaders($headers);

        $options = [
            CURLOPT_URL => $uri,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER     => $headers,
        ];

        if ($method->isPost()) {
            $options += [
                CURLOPT_POST       => true,
                CURLOPT_POSTFIELDS => $body,
            ];
        }

        if ($this->options) {
            $options += $this->options;
        }

        curl_setopt_array($this->curlHandle, $options);

        $response = (string) curl_exec($this->curlHandle);
        $this->guardResponse($response);
        curl_reset($this->curlHandle); //reset default options

        return $response;
    }

    private function guardResponse(string $response): void
    {
        if (empty($response)) {
           $error = curl_error($this->curlHandle);

           if ($error) {
               throw new HttpException(400, $error);
           } else {
               throw new HttpException(500, 'Empty response');
           }
        }

        $httpCode = curl_getinfo($this->curlHandle, CURLINFO_HTTP_CODE);
        if ($httpCode >= 400) {
            throw new HttpException($httpCode, curl_error($this->curlHandle));
        }
    }

    public function __destructor(): void
    {
        curl_close($this->curlHandle);
    }

    /**
     * @param array<string,string> $headers
     * @return array<string>
     */
    private function prepareHeaders(array $headers): array
    {
        if (!$headers) {
            return [];
        }

        $data = [];
        foreach ($headers as $name => $value) {
            $data[] = $name . ':' . $value;
        }

        return $data;
    }
}