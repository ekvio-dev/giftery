<?php

declare(strict_types=1);


namespace Giftery;


use Giftery\Request\Command;
use Giftery\Request\HttpMethod;
use Giftery\Request\Order;
use Giftery\Request\ProductIds;
use Giftery\Request\TaskId;
use Giftery\Request\Zone;
use Giftery\Response\GetAddressResponse;
use Giftery\Response\GetBalanceResponse;
use Giftery\Response\GetCategoriesResponse;
use Giftery\Response\GetCertificateResponse;
use Giftery\Response\GetCodeResponse;
use Giftery\Response\GetLinksResponse;
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

    private string $host = 'https://ssl-api.giftery.ru/?';

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

    public function getStatus(TaskId $id): GetStatusResponse
    {
        $response = $this->request(HttpMethod::GET, Command::GET_STATUS, $this->encoder->encode(['id' => $id->value()]));
        return new GetStatusResponse($response);
    }

    public function getCertificate(TaskId $id): GetCertificateResponse
    {
        $response = $this->request(HttpMethod::GET, Command::GET_CERTIFICATE, $this->encoder->encode(['queue_id' => $id->value()]));
        return new GetCertificateResponse($response);
    }

    public function getCode(TaskId $id): GetCodeResponse
    {
        $response = $this->request(HttpMethod::GET, Command::GET_CODE, $this->encoder->encode(['queue_id' => $id->value()]));
        return new GetCodeResponse($response);
    }

    public function getLinks(TaskId $id): GetLinksResponse
    {
        $response = $this->request(HttpMethod::GET, Command::GET_LINKS, $this->encoder->encode(['queue_id' => $id->value()]));
        return new GetLinksResponse($response);
    }

    public function getCategories(): GetCategoriesResponse
    {
        $response = $this->request(HttpMethod::GET, Command::GET_CATEGORIES);
        return new GetCategoriesResponse($response);
    }

    public function getAddress(ProductIds $ids, Zone $zone): GetAddressResponse
    {
        $data = [];
        if ($ids->value()) {
            $data['product_id'] = $ids->value();
        }

        if ($zone->area()) {
            $data['area_name'] = $zone->area();
        }

        if ($zone->locality()) {
            $data['locality_name'] = $zone->locality();
        }

        $body = count($data)>0 ? $this->encoder->encode($data) : '';

        $response = $this->request(HttpMethod::GET, Command::GET_ADDRESS, $body);
        return new GetAddressResponse($response);
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

        $response = $this->httpClient->request($method, $uri, $headers, $body);
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