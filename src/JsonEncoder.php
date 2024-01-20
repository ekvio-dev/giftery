<?php

declare(strict_types=1);


namespace App;


class JsonEncoder implements Encoder
{
    public function encode(mixed $data): string
    {
        return json_encode($data, JSON_THROW_ON_ERROR);
    }

    public function decode(string $data): array
    {
        return json_decode($data, true);
    }
}