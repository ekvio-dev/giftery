<?php

declare(strict_types=1);


namespace App;


use App\Request\Order;
use App\Response\GetBalanceResponse;
use App\Response\GetTestResponse;
use App\Response\MakeOrderResponse;
use App\Response\GetProductsResponse;
use App\Response\GetStatusResponse;

interface Giftery
{
    public function getProducts(): GetProductsResponse;
    public function makeOrder(Order $order): MakeOrderResponse;
    public function getBalance(): GetBalanceResponse;
    public function getStatus(int $id): GetStatusResponse;
    public function test(): GetTestResponse;
}