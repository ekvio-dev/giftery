<?php

declare(strict_types=1);


namespace Giftery\Response;


final class Addresses
{
    /**
     * @var array<string,mixed> $data
     */
    private array $data;

    /**
     * @param array<string,mixed> $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return array<string,mixed>
     */
    public function data(): array
    {
        return $this->data;
    }
}