<?php

declare(strict_types=1);


namespace Giftery;


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

interface Giftery
{
    public function getProducts(): GetProductsResponse;
    public function makeOrder(Order $order): MakeOrderResponse;
    public function getBalance(): GetBalanceResponse;
    public function getStatus(TaskId $id): GetStatusResponse;
    public function getCertificate(TaskId $id): GetCertificateResponse;
    public function getCode(TaskId $id): GetCodeResponse;
    public function getLinks(TaskId $id): GetLinksResponse;
    public function getCategories(): GetCategoriesResponse;
    public function getAddress(ProductIds $ids, Zone $zone): GetAddressResponse;
    public function test(): GetTestResponse;
}