<?php

declare(strict_types=1);

function getOrNull(mixed $value): mixed
{
    $default = [0];
    if (in_array($value, $default, true)) {
        return $value;
    }

    if (empty($value)) {
        return null;
    }

    return $value;
}