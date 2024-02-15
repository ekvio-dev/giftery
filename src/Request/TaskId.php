<?php

declare(strict_types=1);


namespace Giftery\Request;


use InvalidArgumentException;

final class TaskId
{
    private readonly int $id;
    private function __construct(int $id)
    {
        $this->id = $id;
    }

    public static function fromInt(int $id): self
    {
        if ($id <= 0) {
            throw new InvalidArgumentException('Queue task ID must be positive integer');
        }

        return new self($id);
    }

    public function value(): int
    {
        return $this->id;
    }
}