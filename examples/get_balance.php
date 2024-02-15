<?php

declare(strict_types=1);

use Giftery\CurlClient;
use Giftery\GifteryApi;

require_once __DIR__ .'/../vendor/autoload.php';

$api = new GifteryApi(new CurlClient(), 1, 'secret');
print_r($api->getBalance());