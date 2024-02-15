<?php

declare(strict_types=1);

use Giftery\CurlClient;
use Giftery\GifteryApi;
use Giftery\Request\Order;
use Giftery\Request\TaskId;

require_once __DIR__ .'/../vendor/autoload.php';

$api = new GifteryApi(new CurlClient(), 1, 'secret');

//Create order with certificate
$order = (new Order('xxx', 1, 100))->addEmailTo('test@to.dev');
$task = $api->makeOrder($order);
$certificate = $api->getCertificate(TaskId::fromInt($task->id()));

//Create order with code
$order = (new Order('xxx2', 1, 100))->addEmailTo('test@to.dev');
$task = $api->makeOrder($order);
$code = $api->getCode(TaskId::fromInt($task->id()));

//Create order with link
$order = (new Order('xxx3', 1, 100))->addEmailTo('test@to.dev');
$task = $api->makeOrder($order);
$link = $api->getLinks(TaskId::fromInt($task->id()));