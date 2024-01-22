<?php

declare(strict_types=1);


namespace Giftery;


interface Encoder
{
    public function encode(mixed $data): string;

    /**
     * @param string $data
     * @return array<string,mixed>
     */
    public function decode(string $data): array;
}