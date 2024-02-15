<?php

declare(strict_types=1);


namespace Giftery\Request;


use InvalidArgumentException;

final class ProductIds
{
    /**
     * @var array<int, non-negative-int>
     */
    private array $ids;
    private function __construct(){}

    /**
     * @param array<int, non-negative-int> $ids
     * @return self
     */
    public static function createFromArray(array $ids): self
    {
        foreach ($ids as $id) {
            if ($id <= 0) {
                throw new InvalidArgumentException('Product ID must be only positive integer');
            }
        }


        $self = new self();
        $self->ids = $ids;

        return $self;
    }

    public static function createEmpty(): self
    {
        $self = new self();
        $self->ids = [];

        return $self;
    }

    /**
     * @return array<int,non-negative-int>
     */
    public function value(): array
    {
        return $this->ids;
    }
}