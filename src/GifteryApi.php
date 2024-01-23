<?php

declare(strict_types=1);


namespace Giftery;


use Giftery\Request\Command;
use Giftery\Request\HttpMethod;
use Giftery\Request\Order;
use Giftery\Response\GetBalanceResponse;
use Giftery\Response\GetTestResponse;
use Giftery\Response\MakeOrderResponse;
use Giftery\Response\GetProductsResponse;
use Giftery\Response\GetStatusResponse;

class GifteryApi implements Giftery
{
    private HttpClient $httpClient;
    private Encoder $encoder;
    private int $clientId;
    private string $clientSecret;

    private string $host = 'https://ab-ssl-api.giftery.ru/?';

    /**
     * @var array<string,string>
     */
    private array $options = [];

    /**
     * @param HttpClient $httpClient
     * @param int $clientId
     * @param string $clientSecret
     * @param array<string,string> $options
     */
    public function __construct(HttpClient $httpClient, int $clientId, string $clientSecret, array $options = [])
    {
        if ($clientId <= 0) {
            throw new \InvalidArgumentException('Invalid Client ID');
        }

        $this->clientId = $clientId;

        if (empty(trim($clientSecret))) {
            throw new \InvalidArgumentException('Invalid Client Secret');
        }

        $this->clientSecret = $clientSecret;

        if (!empty($options['host'])) {
            $this->host = $options['host'];
        }

        $this->httpClient = $httpClient;
        $this->encoder = new JsonEncoder();

        $this->options += $options;
    }
    public function getProducts(): GetProductsResponse
    {
        $response = $this->request(HttpMethod::GET, Command::GET_PRODUCTS);
        return new GetProductsResponse($response);
    }

    public function getBalance(): GetBalanceResponse
    {
        $response = $this->request(HttpMethod::GET, Command::GET_BALANCE);
        return new GetBalanceResponse($response);
    }

    public function makeOrder(Order $order): MakeOrderResponse
    {
        $response = $this->request(HttpMethod::POST, Command::MAKE_ORDER, $this->encoder->encode($order));
        return new MakeOrderResponse($response);
    }

    public function getStatus(int $id): GetStatusResponse
    {
        $response = $this->request(HttpMethod::GET, Command::GET_STATUS, $this->encoder->encode(['id' => $id]));
        return new GetStatusResponse($response);
    }

    public function test(): GetTestResponse
    {
        $response = $this->request(HttpMethod::GET, Command::TEST);
        return new GetTestResponse($response);
    }

    /**
     * @return array<string,mixed>
     */
    private function request(HttpMethod $method, Command $command, string $data = ''): array
    {
        $uri = $this->buildUri($method, $command, $data);
        $headers = $method->isPost() ? ['Content-Type' => 'application/x-www-form-urlencoded'] : [];
        $body = $method->isPost() ? $this->buildBody($command, $data) : '';

        $response = $this->httpClient->request($method, $command, $uri, $headers, $body);
        return $this->encoder->decode($response);
    }

    private function buildUri(HttpMethod $method, Command $command, string $data = ''): string
    {
        $params = [
            'id' => $this->clientId,
            'cmd' => $command->value,
            'in' => 'json',
            'out' => 'json',
            'sig' => $this->createSign($command, $data)
        ];

        if ($method->isGet() && $data) {
            $params['data'] = $data;
        }

        return $this->host . http_build_query($params);
    }

    private function buildBody(Command $command, string $data): string
    {
        if (empty($data)) {
            return '';
        }

        return http_build_query([
            'data' => $data,
            'sig' => $this->createSign($command, $data)
        ]);
    }

    private function createSign(Command $command, string $data): string
    {
        return hash('sha256', sprintf('%s%s%s', $command->value, $data, $this->clientSecret));
    }
}