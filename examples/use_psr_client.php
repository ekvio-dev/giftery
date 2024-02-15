<?php

declare(strict_types=1);

require_once __DIR__ .'/../vendor/autoload.php';

$httpFactory = new \GuzzleHttp\Psr7\HttpFactory();
$httpClient = new \GuzzleHttp\Client();

$psrClient = new \Giftery\PsrHttpClient($httpFactory, $httpClient);
$apiClient = new \Giftery\GifteryApi($psrClient, 22665, 'hB5j!xffKtduuax53gAp');
print_r($apiClient->test());