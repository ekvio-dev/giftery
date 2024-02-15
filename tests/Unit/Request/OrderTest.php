<?php

declare(strict_types=1);


namespace Giftery\Tests\Unit\Request;


use Giftery\Request\DeliveryType;
use Giftery\Request\Order;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase
{
    public function testExceptionWhenEmptyUUID(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Order('', 1, 1);
    }

    public function testExceptionWhenUUIDExceedLength(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Order(str_repeat('x', 37), 1, 1);
    }

    public function testExceptionWhenNotPositiveIntegerProductIdUsed(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Order('xxx', 0, 1);
    }

    public function testExceptionWhenNegativeFaceUsed(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Order('xxx', 1, -1);
    }

    public function testCreateDefaultOrder(): void
    {
        $order = new Order('xxx', 1, 1);
        $this->assertEquals('{"product_id":1,"face":1,"uuid":"xxx"}', json_encode($order));
    }

    public function testCreateOrderWithEmail(): void
    {
        $order = Order::OrderWithEmail('xxx', 1, 1, 'test@to.dev');
        $this->assertEquals('{"product_id":1,"face":1,"uuid":"xxx","email_to":"test@to.dev"}', json_encode($order));
    }

    public function testExceptionWhenCreateOrderWithEmptyEmailFromString(): void
    {
        $this->expectException(InvalidArgumentException::class);
        (new Order('xxx', 1, 1))
            ->addEmailFrom('invalid@');
    }

    public function testExceptionWhenCreateOrderWithEmailToString(): void
    {
        $this->expectException(InvalidArgumentException::class);
        (new Order('xxx', 1, 1))
            ->addEmailTo('invalid@');
    }

    public function testExceptionWhenEmptyFromName(): void
    {
        $this->expectException(InvalidArgumentException::class);
        (new Order('xxx', 1, 1))
            ->addFromName('');
    }

    public function testExceptionWhenFromNameExceedLength(): void
    {
        $this->expectException(InvalidArgumentException::class);
        (new Order('xxx', 1, 1))
            ->addFromName(str_repeat('x', 256));
    }

    public function testExceptionWhenEmptyToName(): void
    {
        $this->expectException(InvalidArgumentException::class);
        (new Order('xxx', 1, 1))
            ->addToName('');
    }

    public function testExceptionWhenToNameExceedLength(): void
    {
        $this->expectException(InvalidArgumentException::class);
        (new Order('xxx', 1, 1))
            ->addToName(str_repeat('x', 256));
    }

    public function testExceptionWhenEmptyPhoneNumber(): void
    {
        $this->expectException(InvalidArgumentException::class);
        (new Order('xxx', 1, 1))
            ->addPhoneNumber('');
    }

    public function testExceptionWhenInvalidPhoneNumber(): void
    {
        $this->expectException(InvalidArgumentException::class);
        (new Order('xxx', 1, 1))
            ->addPhoneNumber('546');
    }

    public function testExceptionWhenEmptyDateSend(): void
    {
        $this->expectException(InvalidArgumentException::class);
        (new Order('xxx', 1, 1))
            ->addDateSend('');
    }

    public function testExceptionWhenInvalidFormatDateSend(): void
    {
        $this->expectException(InvalidArgumentException::class);
        (new Order('xxx', 1, 1))
            ->addDateSend('2024-01-01T22:44:26 00:00');
    }

    public function testExceptionWhenEmptyText(): void
    {
        $this->expectException(InvalidArgumentException::class);
        (new Order('xxx', 1, 1))
            ->addText('');
    }

    public function testExceptionWhenTextExceedLength(): void
    {
        $this->expectException(InvalidArgumentException::class);
        (new Order('xxx', 1, 1))
            ->addText(str_repeat('a', 513));
    }

    public function testExceptionWhenEmptyCode(): void
    {
        $this->expectException(InvalidArgumentException::class);
        (new Order('xxx', 1, 1))
            ->addCode('');
    }

    public function testExceptionWhenInvalidCode(): void
    {
        $this->expectException(InvalidArgumentException::class);
        (new Order('xxx', 1, 1))
            ->addCode('aza');
    }

    public function testExceptionWhenEmptyComment(): void
    {
        $this->expectException(InvalidArgumentException::class);
        (new Order('xxx', 1, 1))
            ->addComment('');
    }

    public function testExceptionWhenCommentExceedLength(): void
    {
        $this->expectException(InvalidArgumentException::class);
        (new Order('xxx', 1, 1))
            ->addComment(str_repeat('x', 513));
    }

    public function testExceptionWhenEmptyExternalId(): void
    {
        $this->expectException(InvalidArgumentException::class);
        (new Order('xxx', 1, 1))
            ->addExternalId('');
    }

    public function testExceptionWhenExternalIdExceedLength(): void
    {
        $this->expectException(InvalidArgumentException::class);
        (new Order('xxx', 1, 1))
            ->addExternalId(str_repeat('x', 256));
    }

    public function testExceptionWhenTtlTooSmall(): void
    {
        $this->expectException(InvalidArgumentException::class);
        (new Order('xxx', 1, 1))
            ->addOrderTTL(0);
    }

    public function testExceptionWhenTtlTooHigh(): void
    {
        $this->expectException(InvalidArgumentException::class);
        (new Order('xxx', 1, 1))
            ->addOrderTTL(86401);
    }

    public function testCreateOrderWithAllModficators(): void
    {
        $order = (new Order('xxx', 1, 1))
            ->addEmailFrom('email@from.dev')
            ->addEmailTo('email@to.dev')
            ->addFromName('test')
            ->addToName('customer')
            ->addPhoneNumber('79001234567')
            ->addDateSend('2024-01-01T22:44:26+00:00')
            ->addText('Order text')
            ->addCode('12345')
            ->addComment('Order comment')
            ->addExternalId('abcdef')
            ->addOrderTTL(1000)
            ->addDeliverType(DeliveryType::EMAIL);

        $this->assertEquals('{"product_id":1,"face":1,"uuid":"xxx","email_from":"email@from.dev","email_to":"email@to.dev","from":"test","to":"customer","to_phone":"79001234567","date_send":"2024-01-01T22:44:26+00:00","text":"Order text","code":"12345","comment":"Order comment","external_id":"abcdef","delivery_type":"email","ttl":1000}', json_encode($order));
    }
}