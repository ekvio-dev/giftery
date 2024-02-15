<?php

declare(strict_types=1);


namespace Giftery\Tests\Unit\Request;


use Giftery\Request\TaskId;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class TaskIdTest extends TestCase
{
    public function testCreateTaskIdFromPositiveInteger(): void
    {
        $taskId = TaskId::fromInt(100);
        $this->assertEquals(100, $taskId->value());
    }

    public function testExceptionWhenTaskIdNotPositive(): void
    {
        $this->expectException(InvalidArgumentException::class);
        TaskId::fromInt(0);
    }
}