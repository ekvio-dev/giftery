<br>

## About The Project

Another HTTP client for [Giftery API](https://docs.giftery.tech/b2b-api/) with support PSR 7/17/18 compatible HTTP client


<!-- GETTING STARTED -->
## Getting Started

Before use API client you need get credentials pair of Client ID and Client Secret from Giftery Administration

### Installation

Install from packagist
```sh
   composer install ekvio-dev/giftery
   ```

<!-- USAGE EXAMPLES -->
## Usage
Create GifteryApi object with Http client. By default, project supports CURL implementation.
```php
   $apiClient = new \Giftery\GifteryApi(new CurlClient(), 12345, 'secret');
   $response = $apiClient->getBalance();
   ```
or you can use PSR 7/17/18 compatible HTTP client (example: [ghuzzle](https://github.com/guzzle/guzzle))
```php
    $httpFactory = new \GuzzleHttp\Psr7\HttpFactory();
    $httpClient = new \GuzzleHttp\Client();

    $psrClient = new \Giftery\PsrHttpClient($httpFactory, $httpClient);
    $apiClient - new \Giftery\GifteryApi($psrClient, 12345, 'secret');
    $response = $apiClient->getBalance();
   ```
or you can create you Giftery\HttpClient implementation.
<br>
<br>

API client support methods: getBalance, getProducts, makeOrder, getStatus, getCertificate, getCode, getLinks, getCategories, getAddress, test.


