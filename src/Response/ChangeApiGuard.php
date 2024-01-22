<?php

declare(strict_types=1);


namespace Giftery\Response;


use Giftery\Exception\ChangeApiException;

class ChangeApiGuard
{
    /**
     * @param array<string,mixed> $from
     * @param string $field
     * @param string $path
     * @param array<string,mixed> $data
     * @return mixed
     * @throws ChangeApiException
     */
    public static function getValue(array $from, string $field, string $path, array $data): mixed
    {
        if (!array_key_exists($field, $from)) {
            throw new ChangeApiException($path, $data);
        }

        return $from[$field];
    }
}