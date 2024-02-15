<?php

declare(strict_types=1);


namespace Giftery\Tests\Unit;


use Giftery\GifteryApi;
use Giftery\Request\DeliveryType;
use Giftery\Request\Order;
use Giftery\Request\ProductIds;
use Giftery\Request\TaskId;
use Giftery\Request\Zone;
use Giftery\Response\GetAddressResponse;
use Giftery\Response\GetCategoriesResponse;
use Giftery\Response\GetCertificateResponse;
use Giftery\Response\GetCodeResponse;
use Giftery\Response\GetLinksResponse;
use Giftery\Response\GetStatusResponse;
use Giftery\Response\GetTestResponse;
use Giftery\Tests\Dummy\DummyHttpClient;
use PHPUnit\Framework\TestCase;

class GifteryApiTest extends TestCase
{
    private GifteryApi $apiClient;

    public function setUp(): void
    {
        $this->apiClient = new GifteryApi(new DummyHttpClient(), 1, 'secret');
    }
    public function testBalanceApiCall(): void
    {
        $response = $this->apiClient->getBalance();
        $this->assertEquals(1000, $response->balance());
    }

    public function testGetProductsApiCall(): void
    {
        $response = $this->apiClient->getProducts();
        $this->assertCount(2, $response->products());
    }

    public function testMakeOrderApiCall(): void
    {
        $order = (new Order('xxx', 1, 100))->addDeliverType(DeliveryType::LINK);
        $response = $this->apiClient->makeOrder($order);
        $this->assertIsInt($response->id());
    }

    public function testGetStatusApiCall(): void
    {
        $response = $this->apiClient->getStatus(TaskId::fromInt(1));
        $this->assertInstanceOf(GetStatusResponse::class, $response);
    }

    public function testGetCertificateApiCall(): void
    {
        $response = $this->apiClient->getCertificate(TaskId::fromInt(1));
        $this->assertInstanceOf(GetCertificateResponse::class, $response);
    }

    public function testGetCodeApiCall(): void
    {
        $response = $this->apiClient->getCode(TaskId::fromInt(1));
        $this->assertInstanceOf(GetCodeResponse::class, $response);
    }

    public function testGetLinksApiCall(): void
    {
        $response = $this->apiClient->getLinks(TaskId::fromInt(1));
        $this->assertInstanceOf(GetLinksResponse::class, $response);
    }

    public function testGetCategoriesApiCall(): void
    {
        $response = $this->apiClient->getCategories();
        $this->assertInstanceOf(GetCategoriesResponse::class, $response);
    }

    public function testTestApiCall(): void
    {
        $response = $this->apiClient->test();
        $this->assertInstanceOf(GetTestResponse::class, $response);
    }

    public function testGetAddressApiCall(): void
    {
        $response = $this->apiClient->getAddress(ProductIds::createFromArray([11459]), Zone::createEmpty());
        $this->assertInstanceOf(GetAddressResponse::class, $response);
    }
}