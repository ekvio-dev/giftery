<?php

declare(strict_types=1);


namespace App;


use App\Exception\HttpException;
use App\Request\Command;
use App\Request\HttpMethod;
use App\Request\Order;
use App\Response\GetBalanceResponse;
use App\Response\GetTestResponse;
use App\Response\MakeOrderResponse;
use App\Response\GetProductsResponse;
use App\Response\GetStatusResponse;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;

class GifteryPsrApi implements Giftery
{
    private RequestFactoryInterface&StreamFactoryInterface $httpFactory;
    private ClientInterface $client;
    private Encoder $encoder;
    private int $clientId;
    private string $clientSecret;

    private string $host = 'https://ssl-api.giftery.ru/?';

    /**
     * @var array<string,string>
     */
    private array $options = [];

    /**
     * @param RequestFactoryInterface&StreamFactoryInterface $httpFactory
     * @param ClientInterface $client
     * @param int $clientId
     * @param string $clientSecret
     * @param array<string,string> $options
     */
    public function __construct(RequestFactoryInterface&StreamFactoryInterface $httpFactory, ClientInterface $client, int $clientId, string $clientSecret, array $options = [])
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

        $this->httpFactory = $httpFactory;
        $this->client = $client;
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
     * @throws HttpException
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    private function request(HttpMethod $method, Command $command, string $data = ''): array
    {
        $request = $this->httpFactory->createRequest($method->value, $this->buildUri($method, $command, $data));

        if ($method->isPost()) {
            $request = $request->withHeader('Content-Type', 'application/x-www-form-urlencoded');
            $request = $request->withBody(
                $this->httpFactory->createStream($this->buildBody($command, $data))
            );
        }

        $response = $this->client->sendRequest($request);
        $this->guardResponse($response);

        return $this->encoder->decode((string) $response->getBody());
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
        return http_build_query([
            'data' => $data,
            'sig' => $this->createSign($command, $data)
        ]);
    }

    private function guardResponse(ResponseInterface $response): void
    {
        if ($response->getStatusCode() >= 400) {
            throw new HttpException($response->getStatusCode(), $response->getReasonPhrase());
        }
    }

    private function createSign(Command $command, string $data): string
    {
        return hash('sha256', sprintf('%s%s%s', $command->value, $data, $this->clientSecret));
    }
}