<?php

declare(strict_types=1);


namespace Giftery\Tests\Unit\Request;


use Giftery\Request\ProductIds;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class ProductIdsTest extends TestCase
{
    public function testCreateEmptyProductIds(): void
    {
        $ids = ProductIds::createEmpty();
        $this->assertEquals([], $ids->value());
    }

    public function testCreateProductIds(): void
    {
        $ids = ProductIds::createFromArray([1, 2, 3]);
        $this->assertEquals([1, 2, 3], $ids->value());
    }

    public function testExceptionWhenUsedNotPositiveInteger(): void
    {
        $this->expectException(InvalidArgumentException::class);
        ProductIds::createFromArray([1, 0]);
    }
}