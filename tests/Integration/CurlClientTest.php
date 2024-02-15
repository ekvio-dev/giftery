<?php

declare(strict_types=1);


namespace Giftery\Tests\Integration;


use Giftery\CurlClient;
use Giftery\Exception\HttpException;
use Giftery\Request\HttpMethod;

class CurlClientTest extends IntegrationTestCase
{
    private CurlClient $client;
    public function setUp(): void
    {
        $this->client = new CurlClient();
    }
    public function testGetRequest(): void
    {
        $url = $this->getLocalServerUrl();
        $response = $this->client->request(HttpMethod::GET, $url . '/server.php?test=true', [], '');

        $this->assertEquals('GET|test=true||', $response);
    }
    public function testPostRequest(): void
    {
        $url = $this->getLocalServerUrl();
        $response = $this->client->request(HttpMethod::POST, $url.'/server.php?param=fiz', [], '{"test":true}');

        $this->assertEquals('POST|param=fiz|application/x-www-form-urlencoded|{"test":true}', $response);
    }

    public function testNot200Response(): void
    {
        $this->expectException(HttpException::class);
        $url = $this->getLocalServerUrl();
        $this->client->request(HttpMethod::GET, $url.'/header.php?code=400&phrase=br', [], '');
    }

    public function testEmptyResponse(): void
    {
        $this->expectException(HttpException::class);
        $url = $this->getLocalServerUrl();
        $this->client->request(HttpMethod::GET, $url.'/header.php?code=200&phrase=OK&content=', [], '');
    }
}