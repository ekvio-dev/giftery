<?php

declare(strict_types=1);


namespace Giftery;


use Giftery\Request\Order;
use Giftery\Response\GetBalanceResponse;
use Giftery\Response\GetTestResponse;
use Giftery\Response\MakeOrderResponse;
use Giftery\Response\GetProductsResponse;
use Giftery\Response\GetStatusResponse;

interface Giftery
{
    public function getProducts(): GetProductsResponse;
    public function makeOrder(Order $order): MakeOrderResponse;
    public function getBalance(): GetBalanceResponse;
    public function getStatus(int $id): GetStatusResponse;
    public function test(): GetTestResponse;
}